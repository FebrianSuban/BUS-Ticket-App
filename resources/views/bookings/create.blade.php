@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="sticky top-0 z-20 bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-b">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center gap-3">
            <a href="{{ url()->previous() }}" class="shrink-0 active:scale-[0.98] rounded-lg p-2 hover:bg-gray-100" aria-label="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-700"><path fill-rule="evenodd" d="M15.53 4.47a.75.75 0 0 1 0 1.06L9.06 12l6.47 6.47a.75.75 0 1 1-1.06 1.06l-7-7a.75.75 0 0 1 0-1.06l7-7a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
            </a>
            <h1 class="text-lg font-semibold tracking-tight">Form Pemesanan</h1>
        </div>
    </div>
    <div class="max-w-2xl mx-auto px-4 pt-4 pb-24">

    <div class="bg-white p-4 rounded-2xl shadow mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-base">{{ $schedule->route->kota_asal }} → {{ $schedule->route->kota_tujuan }}</h3>
                <p class="text-sm text-gray-600">{{ $schedule->bus->nama_bus }}</p>
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($schedule->tanggal_berangkat)->format('d M Y') }} • {{ \Carbon\Carbon::parse($schedule->route->jam_berangkat)->format('H:i') }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Harga per tiket</p>
                <p class="text-lg font-bold text-blue-600">Rp {{ number_format($schedule->route->harga, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('bookings.store') }}" class="bg-white p-4 rounded-2xl shadow pb-28" id="booking-form">
        @csrf
        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

        <div class="mb-4">
            <label class="block text-gray-700 mb-1" for="nama_penumpang">Nama Penumpang</label>
            <input id="nama_penumpang" type="text" name="nama_penumpang" required autocomplete="name" class="w-full border rounded-lg px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('nama_penumpang') }}" placeholder="Nama lengkap">
            @error('nama_penumpang')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1" for="no_telepon">No. Telepon</label>
            <input id="no_telepon" type="tel" name="no_telepon" required inputmode="tel" autocomplete="tel" class="w-full border rounded-lg px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx">
            @error('no_telepon')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1" for="qty-input">Jumlah Tiket <span class="text-gray-500 text-sm">(Maks: {{ $schedule->kursi_tersedia }})</span></label>
            <div class="flex items-center gap-3">
                <button type="button" class="w-12 h-12 rounded-lg border flex items-center justify-center text-2xl active:scale-95" id="minus-btn" aria-label="Kurangi">−</button>
                <input type="number" name="jumlah_tiket" required min="1" max="{{ $schedule->kursi_tersedia }}" inputmode="numeric" pattern="[0-9]*" class="flex-1 border rounded-lg px-4 py-3 text-center text-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('jumlah_tiket', 1) }}" id="qty-input">
                <button type="button" class="w-12 h-12 rounded-lg border flex items-center justify-center text-2xl active:scale-95" id="plus-btn" aria-label="Tambah">+</button>
            </div>
            @error('jumlah_tiket')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="fixed bottom-0 inset-x-0 bg-white/90 backdrop-blur border-t shadow p-4 pb-[calc(1rem+env(safe-area-inset-bottom))]">
            <div class="max-w-2xl mx-auto flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Total</p>
                    <p class="text-xl font-bold" id="total-price">Rp {{ number_format($schedule->route->harga, 0, ',', '.') }}</p>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg text-base active:scale-[0.99] shadow-sm">Buat Pesanan</button>
            </div>
        </div>
    </form>
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
</div>
@endsection
