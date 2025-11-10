<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket BUS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">BUS Ticket</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a href="{{ route('admin.bookings.index') }}" class="nav-link">Kelola Booking</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.payment_settings.edit') }}" class="nav-link">Pengaturan Pembayaran</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link">Daftar User</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.schedules.index') }}" class="nav-link">Kelola Jadwal</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.buses.index') }}" class="nav-link">Tambah Bus</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.routes.index') }}" class="nav-link">Tambah Rute</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.show') }}" class="nav-link">Profil</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('profile.show') }}" class="nav-link">Profil</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link p-0">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @if(session('success'))
            <div class="container mb-3">
                <div class="alert alert-success mb-0" role="alert">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mb-3">
                <div class="alert alert-danger mb-0" role="alert">{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>
    @stack('modals')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
