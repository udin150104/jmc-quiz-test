@extends('layout')

@section('title', 'Referensi Data Provinsi')

@php
    $page = 'provinsi';
@endphp

@section('content')
    <div class="container-fluid">
        {{-- simple breadcumb --}}
        <x-page-header title="Provinsi" icon="geo-alt-fill" :breadcrumbs="['Referensi Data', 'Provinsi']" />

        <div class="card rounded-0">
            <div class="card-header">
                {{-- header action --}}
                @include('app.provinsi.header')
            </div>
            <div class="card-body">
                {{-- list Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered" id="table-list">
                        <thead class="table-primary bg-primary">
                            <tr>
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
    @include('app.provinsi.modalform')

    {{-- modal delete --}}
    @include('app.deletemodal')

@endsection
