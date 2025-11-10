@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold mb-0">Kelola Rute</h1>
        <a href="{{ route('admin.routes.create') }}" class="btn btn-primary">Tambah Rute</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kota Asal</th>
                    <th>Kota Tujuan</th>
                    <th>Harga</th>
                    <th>Jam Berangkat</th>
                    <th>Jam Tiba</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($routes as $route)
                    <tr>
                        <td>{{ $route->kota_asal }}</td>
                        <td>{{ $route->kota_tujuan }}</td>
                        <td>Rp {{ number_format($route->harga, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($route->jam_berangkat)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($route->jam_tiba)->format('H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.routes.destroy', $route) }}" onsubmit="return confirm('Yakin ingin menghapus rute ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 text-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada rute</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection

