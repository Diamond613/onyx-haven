<?php

use Illuminate\Support\Facades\Route;
use App\Models\Room;
use App\Models\Booking;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BotController;
use App\Http\Controllers\Admin\MessagesController;

// ── Public Routes ──
Route::get("/", function () {
    $featuredRooms = Room::where("is_available", true)
        ->orderByDesc("base_price")
        ->limit(3)
        ->get();
    return view("pages.home", compact("featuredRooms"));
});

Route::get("/api/availability", function () {
    $checkIn = request("check_in");
    $checkOut = request("check_out");
    $guests = max(1, (int) request("guests", 1));

    if (!$checkIn || !$checkOut) {
        return response()->json(['rooms' => [], 'searched' => false]);
    }

    $validator = \Illuminate\Support\Facades\Validator::make(
        ['check_in' => $checkIn, 'check_out' => $checkOut, 'guests' => $guests],
        [
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:10',
        ]
    );

    if ($validator->fails()) {
        return response()->json(['rooms' => [], 'searched' => false, 'errors' => $validator->errors()], 422);
    }

    $rooms = Room::where('is_available', true)
        ->where('capacity', '>=', $guests)
        ->whereDoesntHave('bookings', function ($query) use ($checkIn, $checkOut) {
            $query->where('status', '!=', 'cancelled')
                ->where('check_in', '<', $checkOut)
                ->where('check_out', '>', $checkIn);
        })

        ->get(['name', 'slug', 'description', 'view_type', 'base_price', 'price_modifier', 'images'])
        ->map(function ($room) {
            return [
                'name' => $room->name,
                'slug' => $room->slug,
                'description' => $room->description,
                'view_type' => $room->view_type,
                'base_price' => $room->base_price,
                'price_modifier' => $room->price_modifier,
                'cover_image' => $room->cover_image,
                'images' => $room->images ?? [],
            ];
        });

    return response()->json(['rooms' => $rooms, 'searched' => true]);
});

Route::get("/rooms", function () {
    $rooms = Room::where("is_available", true)
        ->when(request("view_type"), fn($q, $v) => $q->where("view_type", $v))
        ->when(request("min_price"), fn($q, $v) => $q->where("base_price", ">=", $v))
        ->when(request("max_price"), fn($q, $v) => $q->where("base_price", "<=", $v))
        ->when(request("capacity"), fn($q, $v) => $q->where("capacity", ">=", $v))
        ->get();
    $viewTypes = Room::distinct()->pluck("view_type");
    return view("pages.rooms", compact("rooms", "viewTypes"));
});

Route::get("/experiences", function () {
    return view("pages.experiences");
});

Route::get("/about", function () {
    return view("pages.about");
});

Route::get("/booking/{slug}", function ($slug) {
    $room = Room::where("slug", $slug)->firstOrFail();
    $checkIn = request("check_in", now()->addDay()->format("Y-m-d"));
    $checkOut = request("check_out", now()->addDays(2)->format("Y-m-d"));
    $guests = request("guests", 1);
    return view("pages.booking", compact("room", "checkIn", "checkOut", "guests"));
});

Route::post("/booking/{slug}", function ($slug) {
    $room = Room::where("slug", $slug)->firstOrFail();
    $data = request()->validate([
        "guest_name" => "required|string|max:255",
        "guest_email" => "required|email",
        "guest_phone" => "nullable|string|max:20",
        "check_in" => "required|date",
        "check_out" => "required|date|after:check_in",
        "guests" => "required|integer|min:1",
        "special_requests" => "nullable|string",
    ]);

    $overlap = Booking::where('room_id', $room->id)
        ->where('status', '!=', 'cancelled')
        ->where('check_in', '<', $data['check_out'])
        ->where('check_out', '>', $data['check_in'])
        ->exists();

    if ($overlap) {
        return back()
            ->withErrors(['check_in' => 'Sorry, this room is already booked for those dates. Please choose different dates.'])
            ->withInput();
    }

    $nights = \Carbon\Carbon::parse($data["check_in"])->diffInDays($data["check_out"]);
    $totalPrice = $room->base_price * $room->price_modifier * $nights;
    $booking = Booking::create([
        "room_id" => $room->id,
        "guest_name" => $data["guest_name"],
        "guest_email" => $data["guest_email"],
        "guest_phone" => $data["guest_phone"] ?? null,
        "check_in" => $data["check_in"],
        "check_out" => $data["check_out"],
        "guests" => $data["guests"],
        "total_price" => $totalPrice,
        "status" => "pending",
        "payment_status" => "unpaid",
        "special_requests" => $data["special_requests"] ?? null,
    ]);
    return redirect("/payment/{$booking->id}")->with('success', 'Booking created! Please complete your payment.');
});

Route::get("/payment/{id}", function ($id) {
    $booking = Booking::with("room")->findOrFail($id);
    return view("pages.payment", compact("booking"));
});

Route::post("/payment/{id}/process", function ($id) {
    $booking = Booking::findOrFail($id);

    $data = request()->validate([
        "card_number" => "required|string",
        "card_name" => "required|string|max:255",
        "card_expiry" => "required|string",
        "card_cvv" => "required|string",
    ]);

    $digitsOnly = preg_replace('/\D/', '', $data["card_number"]);

    if (strlen($digitsOnly) < 13 || strlen($digitsOnly) > 19) {
        return response()->json([
            "success" => false,
            "message" => "That card number doesn't look right. Please check it and try again.",
        ], 422);
    }

    // Demo decline rule: any test card ending in 0002 simulates a decline,
    // the same way Stripe/Paystack test cards work. Swap this whole block
    // out for a real gateway call later — same input/output shape.
    $isDeclined = substr($digitsOnly, -4) === "0002";

    if ($isDeclined) {
        $booking->update([
            "payment_status" => "failed",
        ]);

        return response()->json([
            "success" => false,
            "message" => "Your card was declined. Please try a different card.",
        ], 402);
    }

    $booking->update([
        "status" => "confirmed",
        "payment_status" => "paid",
        "card_last_four" => substr($digitsOnly, -4),
    ]);

    return response()->json([
        "success" => true,
        "redirect" => "/booking-success/{$booking->id}",
    ]);
});

Route::get("/booking-success/{id}", function ($id) {
    $booking = Booking::with("room")->findOrFail($id);
    return view("pages.booking-success", compact("booking"));
});

// ── Chat Bot ──
Route::post("/api/chat", [ChatController::class, 'handle']);
Route::get("/contact", [ContactController::class, 'show']);
Route::post("/contact", [ContactController::class, 'submit']);
Route::view("/privacy", "pages.privacy");
Route::view("/terms", "pages.terms");

// ── Auth Routes ──
require __DIR__.'/auth.php';

// ── Admin Routes ──
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/stats-json', [DashboardController::class, 'statsJson']);
    Route::resource('/rooms', RoomController::class);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bot', [BotController::class, 'handle']);
    Route::get('/messages', [MessagesController::class, 'index']);
    Route::get('/messages/{message}', [MessagesController::class, 'show']);
    Route::post('/messages/{message}/reply', [MessagesController::class, 'reply']);
    Route::delete('/messages/{message}', [MessagesController::class, 'destroy']);
    Route::get('/bookings/{booking}/status/{status}', [BookingController::class, 'updateStatus']);
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy']);
});