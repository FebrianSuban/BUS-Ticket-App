<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create(Schedule $schedule)
    {
        return view('bookings.create', compact('schedule'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'nama_penumpang' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'jumlah_tiket' => 'required|integer|min:1',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        if ($schedule->kursi_tersedia < $request->jumlah_tiket) {
            return back()->with('error', 'Kursi tidak mencukupi');
        }

        $totalHarga = $schedule->route->harga * $request->jumlah_tiket;

        $booking = Booking::create([
            'kode_booking' => 'BK' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'schedule_id' => $request->schedule_id,
            'nama_penumpang' => $request->nama_penumpang,
            'no_telepon' => $request->no_telepon,
            'jumlah_tiket' => $request->jumlah_tiket,
            'total_harga' => $totalHarga,
            'status' => 'pending',
        ]);

        $schedule->decrement('kursi_tersedia', $request->jumlah_tiket);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking berhasil dibuat');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('bookings.show', compact('booking'));
    }

    public function myBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with(['schedule.bus', 'schedule.route'])
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }
}
