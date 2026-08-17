<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $totalBookings = Booking::count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');
        $recentBookings = Booking::with('room')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'totalBookings',
            'confirmedBookings',
            'pendingBookings',
            'totalRevenue',
            'recentBookings'
        ));
    }

    public function statsJson()
    {
        return response()->json([
            'totalRooms' => Room::count(),
            'totalBookings' => Booking::count(),
            'confirmedBookings' => Booking::where('status', 'confirmed')->count(),
            'totalRevenue' => Booking::where('status', 'confirmed')->sum('total_price'),
        ]);
    }
}