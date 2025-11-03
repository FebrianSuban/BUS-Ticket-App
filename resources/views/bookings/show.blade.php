@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="sticky top-0 z-20 bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-b">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center gap-3">
            <a href="{{ route('bookings.index') }}" class="shrink-0 active:scale-[0.98] rounded-lg p-2 hover:bg-gray-100" aria-label="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-700"><path fill-rule="evenodd" d="M15.53 4.47a.75.75 0 0 1 0 1.06L9.06 12l6.47 6.47a.75.75 0 1 1-1.06 1.06l-7-7a.75.75 0 0 1 0-1.06l7-7a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
            </a>
            <h1 class="text-lg font-semibold tracking-tight">Detail Booking</h1>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 pt-4 pb-6">
    <div class="bg-white p-4 rounded-2xl shadow">
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-white text-sm
                    @if($booking->status == 'confirmed') bg-green-600
                    @elseif($booking->status == 'cancelled') bg-red-600
                    @else bg-yellow-600
                    @endif">
                    {{ strtoupper($booking->status) }}
                </span>
                <span class="text-xs text-gray-500">Kode: {{ $booking->kode_booking }}</span>
            </div>
            <p class="text-lg font-bold">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div class="space-y-2">
                <p><span class="text-gray-500">Nama Penumpang</span><br><span class="font-medium">{{ $booking->nama_penumpang }}</span></p>
                <p><span class="text-gray-500">No. Telepon</span><br><span class="font-medium">{{ $booking->no_telepon }}</span></p>
                <p><span class="text-gray-500">Jumlah Tiket</span><br><span class="font-medium">{{ $booking->jumlah_tiket }}</span></p>
            </div>
            <div class="space-y-2">
                <p><span class="text-gray-500">Rute</span><br><span class="font-medium">{{ $booking->schedule->route->kota_asal }} → {{ $booking->schedule->route->kota_tujuan }}</span></p>
                <p><span class="text-gray-500">Bus</span><br><span class="font-medium">{{ $booking->schedule->bus->nama_bus }}</span></p>
                <p><span class="text-gray-500">Keberangkatan</span><br><span class="font-medium">{{ \Carbon\Carbon::parse($booking->schedule->tanggal_berangkat)->format('d M Y') }} • {{ \Carbon\Carbon::parse($booking->schedule->route->jam_berangkat)->format('H:i') }}</span></p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('bookings.index') }}" class="inline-flex justify-center items-center bg-gray-700 text-white px-6 py-3 rounded-lg hover:bg-gray-800 active:scale-[0.99]">Kembali</a>
            @if($booking->status === 'confirmed')
            <button type="button" onclick="window.print()" class="inline-flex justify-center items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 active:scale-[0.99]">Cetak</button>
            @endif
        </div>
    </div>
    </div>
</div>
@endsection
