@extends('layout')

@section('title', 'Referensi Data Kabupaten/Kota')

@php
    $page = 'kabupaten';
@endphp

@section('content')
    <div class="container-fluid">
        {{-- simple breadcumb --}}
        <x-page-header title="Kabupaten/Kota" icon="geo-fill" :breadcrumbs="['Referensi Data', 'Kabupaten/Kota']" />

        <div class="card rounded-0">
            <div class="card-header">
                {{-- header action --}}
                @include('app.kabupaten.header')
            </div>
            <div class="card-body">
                {{-- list Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered" id="table-list">
                        <thead class="table-primary bg-primary">
                            <tr>
                                <th>Kabupaten/Kota</th>
                                <th>Provinsi</th>
                                <th width="200px"></th>
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
    @include('app.kabupaten.modalform')

    {{-- modal delete --}}
    @include('app.deletemodal')

@endsection
