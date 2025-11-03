<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'schedule.bus', 'schedule.route'])
            ->latest()
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:confirmed,cancelled'
        ]);

        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);

        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            $booking->schedule->increment('kursi_tersedia', $booking->jumlah_tiket);
        }

        return back()->with('success', 'Status booking berhasil diupdate');
    }
}
