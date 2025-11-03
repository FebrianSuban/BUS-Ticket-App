@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="sticky top-0 z-20 bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-b">
        <div class="max-w-3xl mx-auto px-4 py-3 flex items-center justify-between">
            <h1 class="text-lg font-semibold tracking-tight">Pesanan Saya</h1>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 pt-4 pb-6 grid gap-3">
        @forelse($bookings as $booking)
            <a href="{{ route('bookings.show', $booking) }}" class="bg-white p-4 rounded-2xl shadow active:scale-[0.99]">
                <div class="flex items-start gap-3">
                    <div class="shrink-0 w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M19.5 14.25v-2.625a2.625 2.625 0 0 0-2.625-2.625H7.125A2.625 2.625 0 0 0 4.5 11.625V15a1.125 1.125 0 0 0 1.125 1.125h1.5A1.125 1.125 0 0 0 8.25 15v-.75h7.5V15A1.125 1.125 0 0 0 16.875 16.125h1.5A1.125 1.125 0 0 0 19.5 15v-.75ZM6.75 8.25h10.5V7.5a1.5 1.5 0 0 0-1.5-1.5H8.25a1.5 1.5 0 0 0-1.5 1.5v.75Z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-base font-semibold truncate">{{ $booking->schedule->route->kota_asal }} → {{ $booking->schedule->route->kota_tujuan }}</h3>
                            <span class="px-2 py-0.5 rounded-full text-white text-xs
                                @if($booking->status == 'confirmed') bg-green-600
                                @elseif($booking->status == 'cancelled') bg-red-600
                                @else bg-yellow-600
                                @endif">{{ strtoupper($booking->status) }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($booking->schedule->tanggal_berangkat)->format('d M Y') }} • {{ $booking->jumlah_tiket }} tiket</p>
                        <div class="mt-2 flex items-center justify-between">
                            <p class="text-lg font-bold">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">Kode: {{ $booking->kode_booking }}</p>
                        </div>
                    </div>
                    <div class="self-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M8.47 4.47a.75.75 0 0 1 1.06 0l6 6a.75.75 0 0 1 0 1.06l-6 6a.75.75 0 1 1-1.06-1.06L13.94 12 8.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center text-gray-600 bg-white rounded-2xl shadow p-6">Belum ada pesanan</div>
        @endforelse
    </div>
</div>
@endsection
