@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 fw-bold mb-4">Pengaturan Pembayaran</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.payment_settings.update') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Bank (opsional)</label>
                    <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', optional($setting)->bank_name) }}" placeholder="Contoh: BCA / BNI / Mandiri">
                    @error('bank_name')<div class="form-text text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Rekening</label>
                    <input type="text" name="account_number" class="form-control" value="{{ old('account_number', optional($setting)->account_number) }}" placeholder="Masukkan nomor rekening">
                    @error('account_number')<div class="form-text text-danger">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection


