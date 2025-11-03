@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Jadwal</h1>
        <a href="{{ route('admin.schedules.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Tambah Jadwal</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bus</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rute</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kursi Tersedia</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($schedules as $schedule)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $schedule->bus->nama_bus }}</div>
                            <div class="text-sm text-gray-500">{{ $schedule->bus->nomor_polisi }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $schedule->route->kota_asal }} → {{ $schedule->route->kota_tujuan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ \Carbon\Carbon::parse($schedule->tanggal_berangkat)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ \Carbon\Carbon::parse($schedule->route->jam_berangkat)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->route->jam_tiba)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $schedule->kursi_tersedia }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Rp {{ number_format($schedule->route->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada jadwal</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
