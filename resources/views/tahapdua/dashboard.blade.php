@extends('layoutadmin')

@section('title', 'Beranda')

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-uppercase"> <i class="bi bi-speedometer me-2"></i>  Dashboard</li>
            </ol>
        </nav>

        <div class="mt-2  text-dark rounded-0">
            <h1 class="fst-normal fw-light">Selamat Datang , {{ auth()->user()->name}}</h1>
            <h3 class="text-muted fst-normal fw-light">Selamat beraktivitas. 😊</h3>
        </div>
    </div>
@endsection
