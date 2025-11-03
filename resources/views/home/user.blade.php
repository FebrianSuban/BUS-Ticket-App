<div class="min-h-screen bg-gray-50">
    <div class="sticky top-0 z-20 bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-b">
    </div>

    <div class="max-w-3xl mx-auto px-4 pt-4 pb-24">
    <form method="GET" class="bg-white p-4 rounded-2xl shadow mb-6">
        <div class="grid grid-cols-1 gap-3">
            <div>
                <label class="block text-gray-700 mb-1" for="kota_asal">Kota Asal</label>
                <input id="kota_asal" type="text" name="kota_asal" placeholder="Kota Asal" value="{{ request('kota_asal') }}" class="w-full border rounded-lg px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="address-level2">
            </div>
            <div>
                <label class="block text-gray-700 mb-1" for="kota_tujuan">Kota Tujuan</label>
                <input id="kota_tujuan" type="text" name="kota_tujuan" placeholder="Kota Tujuan" value="{{ request('kota_tujuan') }}" class="w-full border rounded-lg px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="address-level2">
            </div>
            <div>
                <label class="block text-gray-700 mb-1" for="tanggal">Tanggal</label>
                <input id="tanggal" type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full border rounded-lg px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="pt-1">
                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg text-base active:scale-[0.99]">Cari</button>
            </div>
        </div>
    </form>

    <div class="grid gap-3">
        @forelse($schedules as $schedule)
            <div class="bg-white p-4 rounded-2xl shadow">
                <div class="flex items-start gap-3">
                    <div class="shrink-0 w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M19.5 14.25v-2.625a2.625 2.625 0 0 0-2.625-2.625H7.125A2.625 2.625 0 0 0 4.5 11.625V15a1.125 1.125 0 0 0 1.125 1.125h1.5A1.125 1.125 0 0 0 8.25 15v-.75h7.5V15A1.125 1.125 0 0 0 16.875 16.125h1.5A1.125 1.125 0 0 0 19.5 15v-.75ZM6.75 8.25h10.5V7.5a1.5 1.5 0 0 0-1.5-1.5H8.25a1.5 1.5 0 0 0-1.5 1.5v.75Z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold">{{ $schedule->route->kota_asal }} → {{ $schedule->route->kota_tujuan }}</h3>
                        <p class="text-sm text-gray-600">{{ $schedule->bus->nama_bus }} ({{ $schedule->bus->nomor_polisi }})</p>
                        <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($schedule->tanggal_berangkat)->format('d M Y') }} • {{ \Carbon\Carbon::parse($schedule->route->jam_berangkat)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->route->jam_tiba)->format('H:i') }}</p>
                        <p class="text-sm text-gray-600">Kursi Tersedia: {{ $schedule->kursi_tersedia }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-blue-600">Rp {{ number_format($schedule->route->harga, 0, ',', '.') }}</p>
                        @auth
                            <a href="{{ route('bookings.create', $schedule) }}" class="mt-2 inline-flex bg-blue-600 text-white px-4 py-2 rounded-lg active:scale-[0.99]">Pesan</a>
                        @else
                            <a href="{{ route('login') }}" class="mt-2 inline-flex bg-blue-600 text-white px-4 py-2 rounded-lg active:scale-[0.99]">Login untuk Pesan</a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-600 bg-white rounded-2xl shadow p-6">Tidak ada jadwal tersedia</div>
        @endforelse
    </div>
    </div>
</div>
@auth
<nav class="fixed bottom-0 inset-x-0 z-30 bg-white/90 backdrop-blur border-t shadow">
    <div class="max-w-3xl mx-auto px-6">
        <div class="grid grid-cols-3 h-14">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center text-gray-600 active:scale-[0.98]" aria-label="Beranda">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M11.47 3.84a.75.75 0 0 1 1.06 0l8.25 8.25a.75.75 0 1 1-1.06 1.06l-.72-.72V20.5A1.5 1.5 0 0 1 17.5 22h-2.75a.75.75 0 0 1-.75-.75V17a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v4.25a.75.75 0 0 1-.75.75H6.5A1.5 1.5 0 0 1 5 20.5v-8.07l-.72.72a.75.75 0 1 1-1.06-1.06l8.25-8.25Z"/></svg>
                <span class="text-[11px]">Beranda</span>
            </a>
            <a href="{{ route('bookings.index') }}" class="flex flex-col items-center justify-center text-gray-600 active:scale-[0.98]" aria-label="My Bookings">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M3.75 6A2.25 2.25 0 0 1 6 3.75h12A2.25 2.25 0 0 1 20.25 6v9A2.25 2.25 0 0 1 18 17.25H6A2.25 2.25 0 0 1 3.75 15V6Zm2.25 9h12V6H6v9Z"/><path d="M6.75 19.5a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Z"/></svg>
                <span class="text-[11px]">My Bookings</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center justify-center" aria-label="Logout">
                @csrf
                <button type="submit" class="flex flex-col items-center justify-center text-gray-600 active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M3.75 4.5A2.25 2.25 0 0 1 6 2.25h6A2.25 2.25 0 0 1 14.25 4.5v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 0 12 3.75H6A.75.75 0 0 0 5.25 4.5v15A.75.75 0 0 0 6 20.25h6a.75.75 0 0 0 .75-.75v-3a.75.75 0 0 1 1.5 0v3A2.25 2.25 0 0 1 12 22.5H6A2.25 2.25 0 0 1 3.75 20.25v-15Zm15.53 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h12l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                    <span class="text-[11px]">Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>
@endauth
