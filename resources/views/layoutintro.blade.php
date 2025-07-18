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
                <a class="nav-link {{ request()->routeIs('app.intro') ? 'active' : '' }}" aria-current="page" href="{{route('app.intro')}}">
                    <i class="bi bi-info-lg me-1"></i> Informasi
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{ route('app.login') }}">
                    @if(auth()->check()) <i class="bi bi-speedometer"></i> Dasboard @else <i class="bi bi-shield-lock me-1"></i> Login @endif
                </a>
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
