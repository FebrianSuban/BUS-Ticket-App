@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Tambah Bus</h1>

    <form method="POST" action="{{ route('admin.buses.store') }}" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama Bus</label>
            <input type="text" name="nama_bus" required class="w-full border rounded px-4 py-2" value="{{ old('nama_bus') }}" placeholder="Contoh: Sinar Jaya">
            @error('nama_bus')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nomor Polisi</label>
            <input type="text" name="nomor_polisi" required class="w-full border rounded px-4 py-2" value="{{ old('nomor_polisi') }}" placeholder="Contoh: B 1234 AB">
            @error('nomor_polisi')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Kapasitas</label>
            <input type="number" name="kapasitas" required min="1" class="w-full border rounded px-4 py-2" value="{{ old('kapasitas') }}" placeholder="Contoh: 40">
            @error('kapasitas')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan</button>
            <a href="{{ route('admin.buses.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">Batal</a>
        </div>
    </form>
</div>
@endsection

