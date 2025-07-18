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

    {{-- Konten Utama --}}
    <main class="flex-fill p-0 m-0">
        @yield('content')
    </main>

</body>

</html>
