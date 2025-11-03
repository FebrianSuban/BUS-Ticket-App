<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Cari Tiket Bus</h1>

    <form method="GET" class="bg-white p-6 rounded-lg shadow mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="kota_asal" placeholder="Kota Asal" value="{{ request('kota_asal') }}" class="border rounded px-4 py-2">
            <input type="text" name="kota_tujuan" placeholder="Kota Tujuan" value="{{ request('kota_tujuan') }}" class="border rounded px-4 py-2">
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="border rounded px-4 py-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Cari</button>
        </div>
    </form>

    <div class="grid gap-4 mb-10">
        @forelse($schedules as $schedule)
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold">{{ $schedule->route->kota_asal }} → {{ $schedule->route->kota_tujuan }}</h3>
                        <p class="text-gray-600">{{ $schedule->bus->nama_bus }} ({{ $schedule->bus->nomor_polisi }})</p>
                        <p class="text-gray-600">{{ \Carbon\Carbon::parse($schedule->tanggal_berangkat)->format('d M Y') }} | {{ \Carbon\Carbon::parse($schedule->route->jam_berangkat)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->route->jam_tiba)->format('H:i') }}</p>
                        <p class="text-gray-600">Kursi Tersedia: {{ $schedule->kursi_tersedia }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($schedule->route->harga, 0, ',', '.') }}</p>
                        @auth
                            <a href="{{ route('bookings.create', $schedule) }}" class="mt-2 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Pesan</a>
                        @else
                            <a href="{{ route('login') }}" class="mt-2 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Login untuk Pesan</a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-600">Tidak ada jadwal tersedia</p>
        @endforelse
    </div>
    </div>
</div>

