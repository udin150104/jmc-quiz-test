<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-page="{{ $page ?? '' }}">
    <div id="layoutWrapper">
        {{-- Sidebar --}}
        <nav id="sidebar" class=" position-relative">
            <h4 class="text-white p-3">
                <button class="btn btn-close btn-sm mt-2 me-2 border-0 rounded-0 float-end only-sm" id="secondToggleSidebar"></button>
                <a href="{{ route('home') }}" class="text-dark text-decoration-none">Quiz JMC IT Consultant</a>
            </h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark"><i class="bi bi-box-arrow-in-down me-2"></i> Barang
                        Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  text-dark" data-bs-toggle="collapse" href="#masterData" role="button">
                        <i class="bi bi-folder2-open me-2"></i> Master Data
                        <i class="bi bi-caret-down small float-end"></i>
                    </a>
                    <div class="collapse ps-4" id="masterData">
                        <a href="#" class="nav-link border-start border-dark text-dark">Kategori</a>
                        <a href="#" class="nav-link border-start border-dark text-dark">Sub Kategori</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link  text-dark"><i class="bi bi-people me-2"></i> Manajemen User</a>
                </li>
            </ul>
        </nav>

        {{-- Main Area --}}
        <div id="mainContent">
            {{-- Topbar --}}
            <nav class="navbar navbar-expand navbar-dark bg-dark shadow-sm">
                <div class="container-fluid">
                    <button class="btn text-white me-2 border-0 rounded-0" id="toggleSidebar">
                        <i class="bi bi-list"></i>
                    </button>

                    <ul class="navbar-nav ms-auto">
                        {{-- <li class="nav-item dropdown me-3">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-bell"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Notifikasi 1</a></li>
                                <li><a class="dropdown-item" href="#">Notifikasi 2</a></li>
                            </ul>
                        </li> --}}

                        <li class="nav-item dropdown">
                            {{-- <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <small>{{ auth()->user()->roles->first()->nama }}</small> <br>
                                <i class="bi bi-person-circle me-2"></i> {{ auth()->user()->name }}
                            </a> --}}
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-4 me-2"></i>

                                <div class="d-flex flex-column text-start ms-2 me-3">
                                    <span class="fw-semibold">{{ auth()->user()->name }}</span>
                                    <small class="small fsc-12">{{ auth()->user()->roles->first()->nama }}</small>
                                </div>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end rounded-0 border-1">
                                <li>
                                    <form action="{{ route('app.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item"> <i
                                                class="bi bi-box-arrow-right me-1"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            {{-- Content --}}
            <main class="flex-grow-1 p-4">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="bg-light px-3 py-3">
                <small>&copy; {{ date('Y') }} Quiz JMC IT Consultant</small>
            </footer>
        </div>
    </div>

</body>

</html>
