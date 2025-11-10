@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 fw-bold mb-4">Kelola Booking</h1>

    <div class="card shadow-sm">
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Penumpang</th>
                    <th>Rute</th>
                    <th>Tanggal</th>
                    <th>Tiket</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->kode_booking }}</td>
                        <td>
                            <div class="fw-semibold">{{ $booking->nama_penumpang }}</div>
                            <div class="text-muted small">{{ $booking->no_telepon }}</div>
                        </td>
                        <td>
                            {{ $booking->schedule->route->kota_asal }} → {{ $booking->schedule->route->kota_tujuan }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($booking->schedule->tanggal_berangkat)->format('d M Y') }}
                        </td>
                        <td>{{ $booking->jumlah_tiket }}</td>
                        <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @if($booking->status == 'confirmed')
                                <span class="badge text-bg-success">confirmed</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="badge text-bg-danger">cancelled</span>
                            @else
                                <span class="badge text-bg-warning">pending</span>
                            @endif
                        </td>
                        @php
                            $latestProof = $booking->latestPaymentProof;
                            $latestProofPath = $latestProof->path ?? $booking->payment_proof_path;
                        @endphp
                        <td style="min-width: 160px;">
                            @if($booking->payment_status === 'paid')
                                <span class="badge text-bg-success">paid</span>
                            @elseif($booking->payment_status === 'pending_verification')
                                <span class="badge text-bg-info">menunggu verifikasi</span>
                            @else
                                <span class="badge text-bg-secondary">unpaid</span>
                            @endif
                            @if($latestProofPath)
                                <div class="mt-1">
                                    <button type="button" class="btn btn-link btn-sm p-0" data-bs-toggle="modal" data-bs-target="#paymentProofModal{{ $booking->id }}">Lihat bukti</button>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($booking->status == 'pending')
                                <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="btn btn-sm btn-success me-1">Konfirmasi</button>
                                </form>
                                <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Batalkan</button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Tidak ada booking</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection

@push('modals')
    @foreach($bookings as $booking)
        @php
            $latestProof = $booking->latestPaymentProof;
            $latestProofPath = $latestProof->path ?? $booking->payment_proof_path;
            $proofUrl = $latestProof ? route('payment-proofs.show', $latestProof) : ($latestProofPath ? asset('storage/' . $latestProofPath) : null);
        @endphp
        @if($proofUrl)
            <div class="modal fade" id="paymentProofModal{{ $booking->id }}" tabindex="-1" aria-labelledby="paymentProofModalLabel{{ $booking->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentProofModalLabel{{ $booking->id }}">Bukti Pembayaran - {{ $booking->kode_booking }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ $proofUrl }}" alt="Bukti Pembayaran" class="img-fluid rounded">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endpush
