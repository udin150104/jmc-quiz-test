<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body data-page="{{ $page ?? '' }}">
    <div id="layoutWrapper" class="showmenu">
        {{-- Sidebar --}}
        <nav id="sidebar">
            <h4 class="text-white p-3">
                <button class="btn btn-close btn-sm mt-2 me-2 border-0 rounded-0 float-end only-sm" id="secondToggleSidebar"></button>
                <a href="{{ route('home') }}" class="text-dark text-decoration-none">Quiz JMC IT Consultant</a>
            </h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a href="{{route('app.dashboard')}}" class="nav-link {{ request()->routeIs('app.dashboard') ? 'active' : '' }}  text-dark"><i class="bi bi-speedometer me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('app.barang-masuk.index')}}" class="nav-link {{ request()->routeIs('app.barang-masuk.index') ? 'active' : '' }} text-dark"><i class="bi bi-box-arrow-in-down me-2"></i> Barang
                        Masuk</a>
                </li>
                @if(auth()->user()->roles->first()->nama ==="Administrator")
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('app.master.*') ? 'active' : '' }} text-dark" data-bs-toggle="collapse" href="#masterData" role="button">
                        <i class="bi bi-folder2-open me-2"></i> Master Data
                        <i class="bi bi-caret-down small float-end"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('app.master.*') ? 'show' : '' }} ps-4" id="masterData">
                        <a href="{{route('app.master.kategori.index')}}" class="nav-link {{ request()->routeIs('app.master.kategori.index') ? 'active' : '' }} border-start border-dark text-dark">Kategori</a>
                        <a href="{{route('app.master.sub-kategori.index')}}" class="nav-link {{ request()->routeIs('app.master.sub-kategori.index') ? 'active' : '' }} border-start border-dark text-dark">Sub Kategori</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{route('app.manajemen-user.index')}}" class="nav-link {{ request()->routeIs('app.manajemen-user.index') ? 'active' : '' }}  text-dark"><i class="bi bi-people me-2"></i> Manajemen User</a>
                </li>
                @endif
            </ul>
        </nav>

        {{-- Main Area --}}
        <div id="mainContent">
            {{-- Topbar --}}
            <nav class="navbar navbar-expand navbar-dark bg-white border-bottom">
                <div class="container-fluid">
                    <button class="btn text-dark me-2 border-0 rounded-0" id="toggleSidebar">
                        <i class="bi bi-list"></i>
                    </button>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" href="#"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-4 me-2 text-dark"></i>

                                <div class="d-flex flex-column text-start ms-2 me-3">
                                    <span class="fw-semibold text-dark">{{ auth()->user()->name }}</span>
                                    <small class="small fsc-12 text-dark">{{ auth()->user()->roles->first()->nama }}</small>
                                </div>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end rounded-0 border-1">
                                <li>
                                    <form action="{{ route('app.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"> <i
                                                class="bi bi-box-arrow-right me-1 "></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            {{-- Content --}}
            <main class="flex-grow-1 py-4">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="bg-dark text-white border-top px-3 py-3">
                <small>&copy; {{ date('Y') }} Quiz JMC IT Consultant</small>
            </footer>
        </div>
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toast-message" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-white">
                <strong class="me-auto">Informasi</strong>
            </div>
            <div class="toast-body bg-white"></div>
        </div>
    </div>
</body>

</html>
