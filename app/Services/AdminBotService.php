<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Booking;
use App\Models\AdminBotLog;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminBotService
{
    const SESSION_KEY = 'admin_bot';

    protected $adminId;
    protected $adminName;

    public function __construct(int $adminId, string $adminName = '')
    {
        $this->adminId = $adminId;
        $this->adminName = $this->firstName($adminName);
    }

    protected function firstName(string $name): string
    {
        $name = trim($name);
        if ($name === '') return '';
        $parts = preg_split('/\s+/', $name);
        return $parts[0];
    }

    protected function nameSuffix(): string
    {
        return $this->adminName ? ", {$this->adminName}" : '';
    }

    public function handle(string $message): array
    {
        $message = trim($message);
        $state = Session::get(self::SESSION_KEY);

        if ($state && preg_match('/^(cancel|stop|nevermind|never mind|abort)\b/i', $message)) {
            Session::forget(self::SESSION_KEY);
            return $this->reply("Okay, cancelled. What else can I do?", $this->helpQuickReplies());
        }

        if ($state) {
            return $this->continueFlow($state, $message);
        }

        return $this->routeIntent($message);
    }

    protected function routeIntent(string $message): array
    {
        $m = strtolower($message);

        if (preg_match('/^(thanks|thank you|thx|appreciate it)\b/i', $m)) {
            return $this->reply("You're welcome{$this->nameSuffix()}! Anything else you need?");
        }

        if (preg_match('/^(how are you|hows it going|how are things|how you doing)\b/i', $m)) {
            return $this->reply("I'm doing well, thanks for asking{$this->nameSuffix()}! Ready to help with rooms or bookings whenever you are.", $this->helpQuickReplies());
        }

        if (preg_match('/^(good morning|good afternoon|good evening)\b/i', $m, $mm)) {
            return $this->reply(ucfirst($mm[1]) . "{$this->nameSuffix()}! What can I help you with today?", $this->helpQuickReplies());
        }

        if (preg_match("/^(who are you|what's your name|what is your name)/i", $m)) {
            return $this->reply("I'm the Onyx Haven admin assistant, I help you manage rooms and bookings without touching the forms, and I always ask before changing anything.");
        }

        if (preg_match('/^(bye|goodbye|see you|see ya|later|gtg)\b/i', $m)) {
            return $this->reply("Talk soon{$this->nameSuffix()}! I'll be here whenever you need me.");
        }

        if (preg_match('/^(help|hi|hello|hey|what can you do|commands?)\b/i', $m)) {
            return $this->reply(
                "Hi{$this->nameSuffix()}! I can help you manage rooms and bookings without touching the forms. Try things like:\n\n".
                "- \"create a room\"\n".
                "- \"list rooms\"\n".
                "- \"delete room Garden Suite\"\n".
                "- \"set price of Garden Suite to 650000\"\n".
                "- \"list bookings\" / \"pending bookings\" / \"today's bookings\"\n".
                "- \"confirm booking 12\" / \"cancel booking 12\"\n".
                "- \"stats\"\n\n".
                "I'll always ask you to confirm before changing anything.",
                $this->helpQuickReplies()
            );
        }

        if (preg_match('/\b(create|add|new)\b.*\broom\b/i', $m)) {
            return $this->startCreateRoom();
        }

        if (preg_match('/\b(list|show|view|all)\b.*\brooms?\b/i', $m) || $m === 'rooms') {
            return $this->listRooms();
        }

        if (preg_match('/\b(delete|remove)\b.*\broom\b/i', $m)) {
            $name = $this->extractTrailingName($message, ['delete', 'remove', 'room', 'called', 'named']);
            return $this->startDeleteRoom($name);
        }

        if (preg_match('/\b(update|change|set)\b.*\bprice\b/i', $m)) {
            return $this->startUpdatePrice($message);
        }

        if (preg_match('/\bconfirm\s+booking\s*#?(\d+)/i', $message, $mm)) {
            return $this->startBookingStatus((int) $mm[1], 'confirmed');
        }

        if (preg_match('/\bcancel\s+booking\s*#?(\d+)/i', $message, $mm)) {
            return $this->startBookingStatus((int) $mm[1], 'cancelled');
        }

        if (preg_match('/\b(delete|remove)\s+booking\s*#?(\d+)/i', $message, $mm)) {
            return $this->startDeleteBooking((int) $mm[2]);
        }

        if (preg_match('/\b(list|show|view)\b.*\bbookings?\b/i', $m) || preg_match('/\bbookings?\b/i', $m)) {
            $filter = null;
            if (str_contains($m, 'pending')) $filter = 'pending';
            elseif (str_contains($m, 'confirmed')) $filter = 'confirmed';
            elseif (str_contains($m, 'cancelled') || str_contains($m, 'canceled')) $filter = 'cancelled';
            elseif (str_contains($m, 'today')) $filter = 'today';
            return $this->listBookings($filter);
        }

        if (preg_match('/\b(stats|statistics|dashboard|how many|revenue)\b/i', $m)) {
            return $this->stats();
        }

        return $this->reply("I didn't quite catch that. Here's what I can help with:", $this->helpQuickReplies());
    }

    protected function helpQuickReplies(): array
    {
        return ['Create a room', 'List rooms', 'List bookings', 'Stats'];
    }

    protected function createRoomSteps(): array
    {
        return ['name', 'base_price', 'capacity', 'view_type', 'amenities', 'description'];
    }

    protected function startCreateRoom(): array
    {
        $this->setState(['intent' => 'create_room', 'awaiting' => 'name', 'fields' => []]);
        return $this->reply("Sure, let's create a new room. What's the room name?");
    }

    protected function continueCreateRoom(array $state, string $message): array
    {
        $awaiting = $state['awaiting'];
        $fields = $state['fields'];

        if ($awaiting === 'confirm') {
            if (preg_match('/^(y|yes|confirm|create|do it|go ahead)\b/i', $message)) {
                return $this->finishCreateRoom($fields);
            }
            if (preg_match('/^(n|no)\b/i', $message)) {
                Session::forget(self::SESSION_KEY);
                return $this->reply("Cancelled, no room was created.", $this->helpQuickReplies());
            }
            return $this->reply("Please reply \"yes\" to create the room, or \"no\" to cancel.");
        }

        switch ($awaiting) {
            case 'name':
                if (mb_strlen($message) < 2) {
                    return $this->reply("That name seems too short, what should the room be called?");
                }
                $fields['name'] = $message;
                break;
            case 'base_price':
                $price = $this->extractNumber($message);
                if ($price === null || $price < 0) {
                    return $this->reply("What's the nightly price in Naira? (just the number, e.g. 650000)");
                }
                $fields['base_price'] = $price;
                break;
            case 'capacity':
                $capacity = $this->extractNumber($message);
                if ($capacity === null || $capacity < 1) {
                    return $this->reply("How many guests can this room sleep? (e.g. 2)");
                }
                $fields['capacity'] = (int) $capacity;
                break;
            case 'view_type':
                if (mb_strlen($message) < 2) {
                    return $this->reply("What's the view type? (e.g. Ocean, Garden, City)");
                }
                $fields['view_type'] = $message;
                break;
            case 'amenities':
                $fields['amenities'] = $message;
                break;
            case 'description':
                if (mb_strlen($message) < 5) {
                    return $this->reply("Give me a short description of the room.");
                }
                $fields['description'] = $message;
                break;
        }

        $steps = $this->createRoomSteps();
        $currentIndex = array_search($awaiting, $steps);
        $nextStep = $steps[$currentIndex + 1] ?? null;

        if ($nextStep === null) {
            $this->setState(['intent' => 'create_room', 'awaiting' => 'confirm', 'fields' => $fields]);
            return $this->reply($this->summarizeNewRoom($fields));
        }

        $this->setState(['intent' => 'create_room', 'awaiting' => $nextStep, 'fields' => $fields]);
        return $this->reply($this->promptFor($nextStep));
    }

    protected function promptFor(string $field): string
    {
        return match ($field) {
            'base_price' => "What's the nightly price in Naira?",
            'capacity' => "How many guests can it sleep?",
            'view_type' => "What's the view type? (e.g. Ocean, Garden, City)",
            'amenities' => "List the amenities, comma separated (e.g. WiFi, Minibar, Balcony)",
            'description' => "Give me a short description of the room.",
            default => "Next?",
        };
    }

    protected function summarizeNewRoom(array $f): string
    {
        return "Here's what I've got:\n\n".
            "- Name: {$f['name']}\n".
            "- Price: NGN {$f['base_price']}/night\n".
            "- Capacity: {$f['capacity']} guests\n".
            "- View: {$f['view_type']}\n".
            "- Amenities: {$f['amenities']}\n".
            "- Description: {$f['description']}\n\n".
            "Create this room? (yes/no)";
    }

    protected function finishCreateRoom(array $fields): array
    {
        $room = Room::create([
            'name' => $fields['name'],
            'slug' => $this->uniqueSlug($fields['name']),
            'description' => $fields['description'],
            'base_price' => $fields['base_price'],
            'price_modifier' => 1.00,
            'capacity' => $fields['capacity'],
            'view_type' => $fields['view_type'],
            'amenities' => array_values(array_filter(array_map('trim', explode(',', $fields['amenities'])))),
            'images' => [],
            'is_available' => true,
        ]);

        $this->log('create_room', ['room_id' => $room->id, 'name' => $room->name]);
        Session::forget(self::SESSION_KEY);

        return $this->reply(
            "Done{$this->nameSuffix()}, \"{$room->name}\" was created and is live. You can add photos from the Rooms page.",
            [],
            [['label' => 'Open room', 'url' => "/admin/rooms/{$room->id}/edit"]],
            true
        );
    }

    protected function startDeleteRoom(?string $name): array
    {
        if (!$name) {
            $this->setState(['intent' => 'delete_room', 'awaiting' => 'name', 'fields' => []]);
            return $this->reply("Which room would you like to delete?");
        }
        return $this->resolveRoomForDeletion($name);
    }

    protected function continueDeleteRoom(array $state, string $message): array
    {
        if ($state['awaiting'] === 'name') {
            return $this->resolveRoomForDeletion($message);
        }

        if ($state['awaiting'] === 'confirm') {
            if (preg_match('/^(y|yes|confirm|delete)\b/i', $message)) {
                return $this->finishDeleteRoom($state['fields']['room_id']);
            }
            if (preg_match('/^(n|no)\b/i', $message)) {
                Session::forget(self::SESSION_KEY);
                return $this->reply("Cancelled, the room was not deleted.", $this->helpQuickReplies());
            }
            return $this->reply("Reply \"yes\" to permanently delete this room, or \"no\" to cancel.");
        }

        Session::forget(self::SESSION_KEY);
        return $this->reply("Something went wrong, let's start over.");
    }

    protected function resolveRoomForDeletion(string $name): array
    {
        $matches = Room::where('name', 'like', "%{$name}%")->get();

        if ($matches->isEmpty()) {
            $this->setState(['intent' => 'delete_room', 'awaiting' => 'name', 'fields' => []]);
            return $this->reply("I couldn't find a room matching \"{$name}\". Try the exact name, or say \"list rooms\".");
        }

        if ($matches->count() > 1) {
            $names = $matches->pluck('name')->implode(', ');
            $this->setState(['intent' => 'delete_room', 'awaiting' => 'name', 'fields' => []]);
            return $this->reply("A few rooms match: {$names}. Which one exactly?");
        }

        $room = $matches->first();
        $this->setState(['intent' => 'delete_room', 'awaiting' => 'confirm', 'fields' => ['room_id' => $room->id]]);
        return $this->reply("Delete \"{$room->name}\" (NGN {$room->base_price}/night)? This can't be undone. (yes/no)");
    }

    protected function finishDeleteRoom(int $roomId): array
    {
        $room = Room::find($roomId);
        if (!$room) {
            Session::forget(self::SESSION_KEY);
            return $this->reply("That room no longer exists.", $this->helpQuickReplies());
        }

        foreach ($room->images ?? [] as $image) {
            Storage::disk('public')->delete($image['path']);
        }

        $name = $room->name;
        $room->delete();

        $this->log('delete_room', ['room_id' => $roomId, 'name' => $name]);
        Session::forget(self::SESSION_KEY);

        return $this->reply("\"{$name}\" has been deleted.", $this->helpQuickReplies(), [], true);
    }

    protected function startUpdatePrice(string $message): array
    {
        if (preg_match('/price\s+(?:of|for)\s+(.+?)\s+to\s+[NGN$]*\s*([\d.]+)/i', $message, $mm)) {
            return $this->resolveRoomForPriceUpdate(trim($mm[1]), (float) $mm[2]);
        }

        $this->setState(['intent' => 'update_price', 'awaiting' => 'name', 'fields' => []]);
        return $this->reply("Which room's price would you like to change?");
    }

    protected function continueUpdatePrice(array $state, string $message): array
    {
        $awaiting = $state['awaiting'];
        $fields = $state['fields'];

        if ($awaiting === 'name') {
            $matches = Room::where('name', 'like', "%{$message}%")->get();
            if ($matches->isEmpty()) {
                return $this->reply("I couldn't find a room matching \"{$message}\". Try again, or \"list rooms\".");
            }
            if ($matches->count() > 1) {
                return $this->reply("A few rooms match: {$matches->pluck('name')->implode(', ')}. Which one exactly?");
            }
            $room = $matches->first();
            $this->setState(['intent' => 'update_price', 'awaiting' => 'price', 'fields' => ['room_id' => $room->id, 'name' => $room->name]]);
            return $this->reply("Got it, \"{$room->name}\" is currently NGN {$room->base_price}/night. What should the new price be?");
        }

        if ($awaiting === 'price') {
            $price = $this->extractNumber($message);
            if ($price === null || $price < 0) {
                return $this->reply("Just the number please, e.g. 650000");
            }
            $fields['price'] = $price;
            $this->setState(['intent' => 'update_price', 'awaiting' => 'confirm', 'fields' => $fields]);
            return $this->reply("Set \"{$fields['name']}\" to NGN {$price}/night? (yes/no)");
        }

        if ($awaiting === 'confirm') {
            if (preg_match('/^(y|yes|confirm)\b/i', $message)) {
                return $this->finishUpdatePrice($fields['room_id'], $fields['price']);
            }
            if (preg_match('/^(n|no)\b/i', $message)) {
                Session::forget(self::SESSION_KEY);
                return $this->reply("Cancelled, price unchanged.", $this->helpQuickReplies());
            }
            return $this->reply("Reply \"yes\" to confirm, or \"no\" to cancel.");
        }

        Session::forget(self::SESSION_KEY);
        return $this->reply("Something went wrong, let's start over.");
    }

    protected function resolveRoomForPriceUpdate(string $name, float $price): array
    {
        $matches = Room::where('name', 'like', "%{$name}%")->get();

        if ($matches->isEmpty()) {
            $this->setState(['intent' => 'update_price', 'awaiting' => 'name', 'fields' => []]);
            return $this->reply("I couldn't find a room matching \"{$name}\". Which room did you mean?");
        }
        if ($matches->count() > 1) {
            $this->setState(['intent' => 'update_price', 'awaiting' => 'name', 'fields' => []]);
            return $this->reply("A few rooms match: {$matches->pluck('name')->implode(', ')}. Which one exactly?");
        }

        $room = $matches->first();
        $this->setState(['intent' => 'update_price', 'awaiting' => 'confirm', 'fields' => ['room_id' => $room->id, 'name' => $room->name, 'price' => $price]]);
        return $this->reply("Set \"{$room->name}\" to NGN {$price}/night (currently NGN {$room->base_price})? (yes/no)");
    }

    protected function finishUpdatePrice(int $roomId, float $price): array
    {
        $room = Room::find($roomId);
        if (!$room) {
            Session::forget(self::SESSION_KEY);
            return $this->reply("That room no longer exists.", $this->helpQuickReplies());
        }

        $old = $room->base_price;
        $room->update(['base_price' => $price]);

        $this->log('update_room_price', ['room_id' => $roomId, 'name' => $room->name, 'old_price' => $old, 'new_price' => $price]);
        Session::forget(self::SESSION_KEY);

        return $this->reply("\"{$room->name}\" is now NGN {$price}/night.", $this->helpQuickReplies());
    }

    protected function listBookings(?string $filter): array
    {
        $query = Booking::with('room')->latest();

        if ($filter === 'pending' || $filter === 'confirmed' || $filter === 'cancelled') {
            $query->where('status', $filter);
        } elseif ($filter === 'today') {
            $query->whereDate('check_in', now()->toDateString());
        }

        $bookings = $query->limit(10)->get();

        if ($bookings->isEmpty()) {
            return $this->reply("No bookings found" . ($filter ? " for \"{$filter}\"" : "") . ".", $this->helpQuickReplies());
        }

        $lines = $bookings->map(function ($b) {
            return "#{$b->id} - {$b->guest_name} - " . ($b->room->name ?? 'Unknown room') .
                " - {$b->check_in->format('M j')} to {$b->check_out->format('M j')} - {$b->status}";
        })->implode("\n");

        return $this->reply("Here are the latest bookings:\n\n{$lines}", ['List pending bookings', "Today's bookings"]);
    }

    protected function startBookingStatus(int $bookingId, string $status): array
    {
        $booking = Booking::with('room')->find($bookingId);
        if (!$booking) {
            return $this->reply("I couldn't find booking #{$bookingId}.", $this->helpQuickReplies());
        }

        $this->setState(['intent' => 'booking_status', 'awaiting' => 'confirm', 'fields' => ['booking_id' => $bookingId, 'status' => $status]]);

        $verb = $status === 'confirmed' ? 'confirm' : 'cancel';
        return $this->reply("{$verb} booking #{$bookingId} for {$booking->guest_name} (" . ($booking->room->name ?? 'room') . ")? (yes/no)");
    }

    protected function continueBookingStatus(array $state, string $message): array
    {
        $fields = $state['fields'];

        if (preg_match('/^(y|yes|confirm)\b/i', $message)) {
            $booking = Booking::find($fields['booking_id']);
            if (!$booking) {
                Session::forget(self::SESSION_KEY);
                return $this->reply("That booking no longer exists.", $this->helpQuickReplies());
            }
            $booking->update(['status' => $fields['status']]);
            $this->log('update_booking_status', ['booking_id' => $booking->id, 'status' => $fields['status']]);
            Session::forget(self::SESSION_KEY);
            return $this->reply("Booking #{$booking->id} is now marked {$fields['status']}.", $this->helpQuickReplies(), [], true);
        }

        if (preg_match('/^(n|no)\b/i', $message)) {
            Session::forget(self::SESSION_KEY);
            return $this->reply("No changes made.", $this->helpQuickReplies());
        }

        return $this->reply("Reply \"yes\" or \"no\".");
    }

    protected function startDeleteBooking(int $bookingId): array
    {
        $booking = Booking::with('room')->find($bookingId);
        if (!$booking) {
            return $this->reply("I couldn't find booking #{$bookingId}.", $this->helpQuickReplies());
        }

        $this->setState(['intent' => 'delete_booking', 'awaiting' => 'confirm', 'fields' => ['booking_id' => $bookingId]]);
        return $this->reply("Permanently delete booking #{$bookingId} for {$booking->guest_name}? This can't be undone. (yes/no)");
    }

    protected function continueDeleteBooking(array $state, string $message): array
    {
        $bookingId = $state['fields']['booking_id'];

        if (preg_match('/^(y|yes|confirm|delete)\b/i', $message)) {
            $booking = Booking::find($bookingId);
            if (!$booking) {
                Session::forget(self::SESSION_KEY);
                return $this->reply("That booking no longer exists.", $this->helpQuickReplies());
            }
            $booking->delete();
            $this->log('delete_booking', ['booking_id' => $bookingId]);
            Session::forget(self::SESSION_KEY);
            return $this->reply("Booking #{$bookingId} has been deleted.", $this->helpQuickReplies(), [], true);
        }

        if (preg_match('/^(n|no)\b/i', $message)) {
            Session::forget(self::SESSION_KEY);
            return $this->reply("Cancelled, booking kept.", $this->helpQuickReplies());
        }

        return $this->reply("Reply \"yes\" to delete, or \"no\" to cancel.");
    }

    protected function listRooms(): array
    {
        $rooms = Room::orderBy('name')->get();
        if ($rooms->isEmpty()) {
            return $this->reply("There are no rooms yet. Want to create one?", ['Create a room']);
        }

        $lines = $rooms->map(fn($r) => "- {$r->name} - NGN {$r->base_price}/night - {$r->capacity} guests - " . ($r->is_available ? 'available' : 'hidden'))->implode("\n");
        return $this->reply("Current rooms:\n\n{$lines}", ['Create a room']);
    }

    protected function stats(): array
    {
        $roomCount = Room::count();
        $pending = Booking::where('status', 'pending')->count();
        $confirmed = Booking::where('status', 'confirmed')->count();
        $revenue = Booking::where('payment_status', 'paid')->sum('total_price');

        return $this->reply(
            "Quick stats:\n\n".
            "- Rooms: {$roomCount}\n".
            "- Pending bookings: {$pending}\n".
            "- Confirmed bookings: {$confirmed}\n".
            "- Revenue collected: NGN " . number_format($revenue, 2),
            $this->helpQuickReplies()
        );
    }

    protected function continueFlow(array $state, string $message): array
    {
        return match ($state['intent']) {
            'create_room' => $this->continueCreateRoom($state, $message),
            'delete_room' => $this->continueDeleteRoom($state, $message),
            'update_price' => $this->continueUpdatePrice($state, $message),
            'booking_status' => $this->continueBookingStatus($state, $message),
            'delete_booking' => $this->continueDeleteBooking($state, $message),
            default => (function () {
                Session::forget(self::SESSION_KEY);
                return $this->reply("Let's start fresh, what would you like to do?", $this->helpQuickReplies());
            })(),
        };
    }

    protected function setState(array $state): void
    {
        Session::put(self::SESSION_KEY, $state);
    }

    protected function reply(string $text, array $quickReplies = [], array $links = [], bool $refreshStats = false): array
    {
        return ['reply' => $text, 'quickReplies' => $quickReplies, 'links' => $links, 'refreshStats' => $refreshStats];
    }

    protected function extractNumber(string $text): ?float
    {
        if (preg_match('/-?\d+(\.\d+)?/', str_replace(',', '', $text), $mm)) {
            return (float) $mm[0];
        }
        return null;
    }

    protected function extractTrailingName(string $message, array $stripWords): ?string
    {
        $words = preg_split('/\s+/', $message);
        $kept = array_filter($words, fn($w) => !in_array(strtolower(trim($w, ",.")), $stripWords));
        $name = trim(implode(' ', $kept));
        return $name !== '' ? $name : null;
    }

    protected function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;
        while (Room::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }

    protected function log(string $action, array $details): void
    {
        AdminBotLog::create([
            'user_id' => $this->adminId,
            'action' => $action,
            'details' => $details,
        ]);
    }
}