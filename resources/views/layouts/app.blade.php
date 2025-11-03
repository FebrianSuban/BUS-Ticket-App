<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket BUS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">BUS Ticket</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.bookings.index') }}" class="text-gray-700 hover:text-blue-600">Kelola Booking</a>
                            <a href="{{ route('admin.schedules.index') }}" class="text-gray-700 hover:text-blue-600">Kelola Jadwal</a>
                            <a href="{{ route('admin.buses.index') }}" class="text-gray-700 hover:text-blue-600">Tambah Bus</a>
                            <a href="{{ route('admin.routes.index') }}" class="text-gray-700 hover:text-blue-600">Tambah Rute</a>
                        @else
                            <!-- <a href="{{ route('bookings.index') }}" class="text-gray-700 hover:text-blue-600">My Bookings</a> -->
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <!-- <button class="text-gray-700 hover:text-blue-600">Logout</button> -->
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
