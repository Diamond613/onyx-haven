<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('room')
            ->latest()
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Booking $booking, $status)
    {
        $booking->update(['status' => $status]);
        return redirect('/admin/bookings')->with('success', 'Booking status updated!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect('/admin/bookings')->with('success', 'Booking deleted!');
    }
}