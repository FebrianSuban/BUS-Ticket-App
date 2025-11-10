@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pt-3 pb-4">
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                <h1 class="h5 mb-0">Detail Booking</h1>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            @if($booking->status == 'confirmed')
                                <span class="badge text-bg-success">CONFIRMED</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="badge text-bg-danger">CANCELLED</span>
                            @else
                                <span class="badge text-bg-warning">PENDING</span>
                            @endif
                            <span class="text-muted small">Kode: {{ $booking->kode_booking }}</span>
                        </div>
                        <p class="fs-5 fw-bold mb-0">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                    </div>

                    <div class="row g-3 small">
                        <div class="col-sm-6">
                            <div>Nama Penumpang<br><span class="fw-semibold">{{ $booking->nama_penumpang }}</span></div>
                            <div>No. Telepon<br><span class="fw-semibold">{{ $booking->no_telepon }}</span></div>
                            <div>Jumlah Tiket<br><span class="fw-semibold">{{ $booking->jumlah_tiket }}</span></div>
                        </div>
                        <div class="col-sm-6">
                            <div>Rute<br><span class="fw-semibold">{{ $booking->schedule->route->kota_asal }} → {{ $booking->schedule->route->kota_tujuan }}</span></div>
                            <div>Bus<br><span class="fw-semibold">{{ $booking->schedule->bus->nama_bus }}</span></div>
                            <div>Keberangkatan<br><span class="fw-semibold">{{ \Carbon\Carbon::parse($booking->schedule->tanggal_berangkat)->format('d M Y') }} • {{ \Carbon\Carbon::parse($booking->schedule->route->jam_berangkat)->format('H:i') }}</span></div>
                        </div>
                    </div>

                    @php
                        $bank = optional($paymentSetting)->bank_name ?: 'BANK';
                        $acc = optional($paymentSetting)->account_number ?: '-';
                        $payload = "Pembayaran BUS Ticket\nKode: {$booking->kode_booking}\nBank: {$bank}\nRek: {$acc}\nJumlah: Rp " . number_format($booking->total_harga, 0, ',', '.');
                        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' . urlencode($payload);
                        $latestProof = $booking->latestPaymentProof;
                        $proofRoute = $latestProof ? route('payment-proofs.show', $latestProof) : ($booking->payment_proof_path ? asset('storage/' . $booking->payment_proof_path) : null);
                    @endphp

                    @if(!empty(optional($paymentSetting)->account_number) && $booking->status === 'pending')
                        <hr class="my-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <img src="{{ $qrUrl }}" width="220" height="220" alt="QR Pembayaran">
                            </div>
                            <div class="col">
                                <p class="mb-2">Silakan transfer sesuai nominal ke:</p>
                                <p class="mb-1 fw-semibold">{{ $bank }} • {{ $acc }}</p>
                                <p class="text-muted small mb-3">Gunakan barcode di samping untuk mempermudah pembayaran.</p>

                                @if($booking->payment_status === 'pending_verification')
                                    <div class="alert alert-info py-2 mb-3">Konfirmasi pembayaran terkirim. Menunggu verifikasi admin.</div>
                                @endif

                                @if($booking->payment_status === 'pending_verification')
                                    @if($proofRoute)
                                        <div class="mb-2">
                                            <a href="{{ $proofRoute }}" target="_blank" class="link-primary">Lihat bukti pembayaran</a>
                                        </div>
                                    @endif
                                    <div class="alert alert-info py-2 mb-0">Konfirmasi pembayaran terkirim. Menunggu verifikasi admin.</div>
                                @elseif($booking->payment_status === 'unpaid')
                                    @if(!$proofRoute)
                                        <form method="POST" action="{{ route('bookings.uploadProof', $booking) }}" enctype="multipart/form-data" class="mb-3">
                                            @csrf
                                            <div class="mb-2">
                                                <label class="form-label">Unggah bukti pembayaran (jpg/png, maks 4MB)</label>
                                                <input type="file" name="payment_proof" accept="image/*" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-outline-primary">Unggah bukti</button>
                                        </form>
                                        @error('payment_proof')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                                        <div class="alert alert-warning py-2">Unggah bukti pembayaran terlebih dahulu sebelum klik konfirmasi.</div>
                                    @else
                                        <div class="mb-2">
                                            <a href="{{ $proofRoute }}" target="_blank" class="link-primary">Lihat bukti pembayaran</a>
                                        </div>
                                        <form method="POST" action="{{ route('bookings.uploadProof', $booking) }}" enctype="multipart/form-data" class="mb-3">
                                            @csrf
                                            <div class="mb-2">
                                                <label class="form-label">Unggah ulang bukti jika perlu (jpg/png, maks 4MB)</label>
                                                <input type="file" name="payment_proof" accept="image/*" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-outline-secondary">Unggah ulang</button>
                                        </form>
                                        @error('payment_proof')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                                        <form method="POST" action="{{ route('bookings.notifyPayment', $booking) }}" class="mb-0">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Saya sudah bayar</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Kembali</a>
                        @if($booking->status === 'confirmed')
                            <button type="button" onclick="window.print()" class="btn btn-primary">Cetak</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
