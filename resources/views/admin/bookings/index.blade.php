@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Kelola Booking</h1>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penumpang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rute</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $booking->kode_booking }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $booking->nama_penumpang }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->no_telepon }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $booking->schedule->route->kota_asal }} → {{ $booking->schedule->route->kota_tujuan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ \Carbon\Carbon::parse($booking->schedule->tanggal_berangkat)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $booking->jumlah_tiket }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($booking->status == 'pending')
                                <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Konfirmasi</button>
                                </form>
                                <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="text-red-600 hover:text-red-900">Batalkan</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada booking</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
