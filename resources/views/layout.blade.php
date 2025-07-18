<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="d-flex flex-column min-vh-100" data-page="{{ $page ?? '' }}">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
        </div>
    </nav>

    {{-- Navigasi sederhana --}}
    <div class="container mt-3 border-bottom">
        <ul class="nav nav-underline">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('app.home') ? 'active' : '' }}" aria-current="page" href="{{route('app.home')}}">
                    <i class="bi bi-house-door-fill me-1"></i> Beranda
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('app.ref.*') ? 'active' : '' }}" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false">
                    <i class="bi bi-collection me-1"></i> Referensi Data
                </a>
                <ul class="dropdown-menu  rounded-0">
                    <li><a class="dropdown-item {{ request()->routeIs('app.ref.provinsi.index') ? 'active' : '' }}" href="{{ route('app.ref.provinsi.index') }}"><i class="bi bi-geo-alt-fill me-1"></i> Provinsi</a>
                    </li>
                    <li><a class="dropdown-item  {{ request()->routeIs('app.ref.kabupaten.index') ? 'active' : '' }}" href="{{ route('app.ref.kabupaten.index') }}"><i class="bi bi-geo-fill me-1"></i> Kabupaten/Kota</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('app.penduduk.index') ? 'active' : '' }}" href="{{ route('app.penduduk.index') }}">
                    <i class="bi bi-people-fill me-1"></i> Penduduk
                </a>
            </li>

            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('app.laporan.*') ? 'active' : '' }}" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false">
                    <i class="bi bi-collection me-1"></i> Laporan
                </a>
                <ul class="dropdown-menu  rounded-0">
                    <li><a class="dropdown-item {{ request()->routeIs('app.laporan.provinsi.index') ? 'active' : '' }}" href="{{ route('app.laporan.provinsi.index') }}"><i class="bi bi-file-earmark-text-fill me-1"></i> Jumlah Penduduk Per Provinsi</a>
                    </li>
                    <li><a class="dropdown-item  {{ request()->routeIs('app.laporan.kabupaten.index') ? 'active' : '' }}" href="{{ route('app.laporan.kabupaten.index') }}"><i class="bi bi-file-earmark-text-fill me-1"></i> Jumlah Penduduk Per Kabupaten/Kota</a></li>
                </ul>
            </li>
        </ul>
    </div>

    {{-- Konten Utama --}}
    <main class="flex-fill container mt-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-light py-4 mt-5">
        <div class="container">
            <small>&copy; {{ date('Y') }} {{ config('app.name') }} </small>
        </div>
    </footer>

</body>

</html>
