@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pt-3 pb-4">
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                <h1 class="h5 mb-0">Form Pemesanan</h1>
            </div>
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h3 class="h6 fw-bold mb-1">{{ $schedule->route->kota_asal }} → {{ $schedule->route->kota_tujuan }}</h3>
                        <div class="text-muted small">{{ $schedule->bus->nama_bus }}</div>
                        <div class="text-muted small">{{ \Carbon\Carbon::parse($schedule->tanggal_berangkat)->format('d M Y') }} • {{ \Carbon\Carbon::parse($schedule->route->jam_berangkat)->format('H:i') }}</div>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small">Harga per tiket</div>
                        <div class="fs-6 fw-bold text-primary">Rp {{ number_format($schedule->route->harga, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('bookings.store') }}" class="card shadow-sm" id="booking-form">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="qty-input">Jumlah Tiket <span class="text-muted small">(Maks: {{ $schedule->kursi_tersedia }})</span></label>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-secondary" id="minus-btn" aria-label="Kurangi">−</button>
                            <input type="number" name="jumlah_tiket" required min="1" max="{{ $schedule->kursi_tersedia }}" inputmode="numeric" class="form-control text-center" value="{{ old('jumlah_tiket', 1) }}" id="qty-input" style="max-width: 120px;">
                            <button type="button" class="btn btn-outline-secondary" id="plus-btn" aria-label="Tambah">+</button>
                        </div>
                        @error('jumlah_tiket')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Total</div>
                            <div class="fs-5 fw-bold" id="total-price">Rp {{ number_format($schedule->route->harga, 0, ',', '.') }}</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    (function(){
        const price = {{ (int) $schedule->route->harga }};
        const maxQty = {{ (int) $schedule->kursi_tersedia }};
        const qtyInput = document.getElementById('qty-input');
        const minusBtn = document.getElementById('minus-btn');
        const plusBtn = document.getElementById('plus-btn');
        const totalPrice = document.getElementById('total-price');
        function formatIDR(n){
            return 'Rp ' + n.toLocaleString('id-ID');
        }
        function update(){
            let v = parseInt(qtyInput.value || '1', 10);
            if (v < 1) v = 1;
            if (v > maxQty) v = maxQty;
            qtyInput.value = v;
            totalPrice.textContent = formatIDR(v * price);
        }
        minusBtn.addEventListener('click', function(){ qtyInput.value = Math.max(1, (parseInt(qtyInput.value||'1') - 1)); update(); });
        plusBtn.addEventListener('click', function(){ qtyInput.value = Math.min(maxQty, (parseInt(qtyInput.value||'1') + 1)); update(); });
        qtyInput.addEventListener('input', update);
        update();
    })();
</script>
@endsection
