@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pt-3 pb-4">
        <div class="col-lg-7">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h1 class="h4 fw-bold mb-0">Profil Saya</h1>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Edit Profil</a>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-2"><span class="text-muted">Nama:</span> {{ $user->name }}</div>
                    <div class="mb-2"><span class="text-muted">Email:</span> {{ $user->email }}</div>
                    <div class="mb-2"><span class="text-muted">No. Telepon:</span> {{ $user->phone ?? '-' }}</div>
                    <div class="mb-2"><span class="text-muted">Role:</span>
                        @if($user->isAdmin())
                            <span class="badge text-bg-primary">Admin</span>
                        @else
                            <span class="badge text-bg-secondary">User</span>
                        @endif
                    </div>
                    <div class="mb-0"><span class="text-muted">Bergabung:</span> {{ $user->created_at?->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


