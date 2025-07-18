@extends('layout')

@section('title', 'Penduduk')

@php
    $page = 'penduduk';
@endphp

@section('content')
    <div class="container-fluid">
        {{-- simple breadcumb --}}
        <x-page-header title="Penduduk" icon="people-fill" :breadcrumbs="['Penduduk']" />

        <div class="card rounded-0">
            <div class="card-header">
                {{-- header action --}}
                @include('app.penduduk.header')
            </div>
            <div class="card-body">
                {{-- list Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered" id="table-list">
                        <thead class="table-primary bg-primary">
                            <tr>
                                <th>Nama</th>
                                <th width="150" class="text-center">Umur</th>
                                <th width="250">Alamat</th>
                                <th width="200"></th>
                            </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <nav>
                    <ul class="pagination" id="pagination"></ul>
                </nav>

            </div>
        </div>

    </div>

    {{-- modal form --}}
    @include('app.penduduk.form')

    {{-- modal delete --}}
    @include('app.deletemodal')

@endsection
