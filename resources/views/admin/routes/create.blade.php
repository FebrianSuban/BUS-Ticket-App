@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Tambah Rute</h1>

    <form method="POST" action="{{ route('admin.routes.store') }}" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Kota Asal</label>
            <input type="text" name="kota_asal" required class="w-full border rounded px-4 py-2" value="{{ old('kota_asal') }}" placeholder="Contoh: Jakarta">
            @error('kota_asal')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Kota Tujuan</label>
            <input type="text" name="kota_tujuan" required class="w-full border rounded px-4 py-2" value="{{ old('kota_tujuan') }}" placeholder="Contoh: Bandung">
            @error('kota_tujuan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Harga</label>
            <input type="number" name="harga" required min="0" class="w-full border rounded px-4 py-2" value="{{ old('harga') }}" placeholder="Contoh: 150000">
            @error('harga')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Jam Berangkat</label>
            <input type="time" name="jam_berangkat" required class="w-full border rounded px-4 py-2" value="{{ old('jam_berangkat') }}">
            @error('jam_berangkat')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Jam Tiba</label>
            <input type="time" name="jam_tiba" required class="w-full border rounded px-4 py-2" value="{{ old('jam_tiba') }}">
            @error('jam_tiba')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan</button>
            <a href="{{ route('admin.routes.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">Batal</a>
        </div>
    </form>
</div>
@endsection

