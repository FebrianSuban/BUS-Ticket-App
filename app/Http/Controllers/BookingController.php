<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use App\Models\PaymentSetting;
use App\Models\PaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'jumlah_tiket' => 'required|integer|min:1',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        if ($schedule->kursi_tersedia < $request->jumlah_tiket) {
            return back()->with('error', 'Kursi tidak mencukupi');
        }

        $totalHarga = $schedule->route->harga * $request->jumlah_tiket;
        $user = auth()->user();
        if (!$user->phone) {
            return back()->with('error', 'Lengkapi nomor telepon di profil Anda sebelum memesan.');
        }

        $booking = Booking::create([
            'kode_booking' => 'BK' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'schedule_id' => $request->schedule_id,
            'nama_penumpang' => $user->name,
            'no_telepon' => $user->phone,
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
        $booking->loadMissing('latestPaymentProof');
        $paymentSetting = PaymentSetting::first();
        return view('bookings.show', compact('booking', 'paymentSetting'));
    }

    public function notifyPayment(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking tidak dapat dikonfirmasi pembayaran pada status saat ini.');
        }
        $booking->loadMissing('latestPaymentProof');
        if (!$booking->latestPaymentProof) {
            return back()->with('error', 'Unggah bukti pembayaran terlebih dahulu sebelum konfirmasi.');
        }
        $booking->update([
            'payment_status' => 'pending_verification',
            'payment_notified_at' => now(),
        ]);
        return back()->with('success', 'Konfirmasi pembayaran terkirim. Mohon tunggu verifikasi admin.');
    }

    public function uploadPaymentProof(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Tidak dapat mengunggah bukti pembayaran untuk booking ini.');
        }
        $request->validate([
            'payment_proof' => 'required|image|max:4096', // max 4MB
        ]);
        $file = $request->file('payment_proof');
        $path = $file->store('payment_proofs', 'public');
        $booking->paymentProofs()->create([
            'path' => $path,
        ]);
        $booking->update([
            'payment_proof_path' => $path,
            'payment_status' => 'unpaid',
        ]);
        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Silakan klik konfirmasi pembayaran.');
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
