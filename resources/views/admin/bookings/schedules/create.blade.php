@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Tambah Jadwal</h1>

    <form method="POST" action="{{ route('admin.schedules.store') }}" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Bus</label>
            <select name="bus_id" required class="w-full border rounded px-4 py-2">
                <option value="">Pilih Bus</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                        {{ $bus->nama_bus }} ({{ $bus->nomor_polisi }}) - Kapasitas: {{ $bus->kapasitas }}
                    </option>
                @endforeach
            </select>
            @error('bus_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Rute</label>
            <select name="route_id" required class="w-full border rounded px-4 py-2">
                <option value="">Pilih Rute</option>
                @foreach($routes as $route)
                    <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                        {{ $route->kota_asal }} → {{ $route->kota_tujuan }} (Rp {{ number_format($route->harga, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
            @error('route_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Tanggal Berangkat</label>
            <input type="date" name="tanggal_berangkat" required class="w-full border rounded px-4 py-2" value="{{ old('tanggal_berangkat') }}" min="{{ date('Y-m-d') }}">
            @error('tanggal_berangkat')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan</button>
            <a href="{{ route('admin.schedules.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">Batal</a>
        </div>
    </form>
</div>
@endsection
