@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold mb-0">Profil User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5 fw-bold mb-3">{{ $user->name }}</h2>
                    <div class="mb-2"><span class="text-muted">Email:</span> {{ $user->email }}</div>
                    <div class="mb-2"><span class="text-muted">No. Telepon:</span> {{ $user->phone ?? '-' }}</div>
                    <div class="mb-2"><span class="text-muted">Role:</span>
                        @if($user->isAdmin())
                            <span class="badge text-bg-primary">Admin</span>
                        @else
                            <span class="badge text-bg-secondary">User</span>
                        @endif
                    </div>
                    <div class="mb-2"><span class="text-muted">Bergabung:</span> {{ $user->created_at?->format('d M Y H:i') }}</div>
                    <div class="mb-0"><span class="text-muted">Total Booking:</span> {{ $user->bookings_count }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


