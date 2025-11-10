@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 fw-bold mb-4">Tambah Rute</h1>

    <form method="POST" action="{{ route('admin.routes.store') }}" class="card shadow-sm">
        @csrf
        <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Kota Asal</label>
            <input type="text" name="kota_asal" required class="form-control" value="{{ old('kota_asal') }}" placeholder="Contoh: Jakarta">
            @error('kota_asal')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kota Tujuan</label>
            <input type="text" name="kota_tujuan" required class="form-control" value="{{ old('kota_tujuan') }}" placeholder="Contoh: Bandung">
            @error('kota_tujuan')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" required min="0" class="form-control" value="{{ old('harga') }}" placeholder="Contoh: 150000">
            @error('harga')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Berangkat</label>
            <input type="time" name="jam_berangkat" required class="form-control" value="{{ old('jam_berangkat') }}">
            @error('jam_berangkat')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Tiba</label>
            <input type="time" name="jam_tiba" required class="form-control" value="{{ old('jam_tiba') }}">
            @error('jam_tiba')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary">Batal</a>
        </div>
        </div>
    </form>
</div>
@endsection

