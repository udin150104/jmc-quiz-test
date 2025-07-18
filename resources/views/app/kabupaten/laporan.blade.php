@extends('layout')

@section('title', 'Laporan Kabupaten/Kota')

@php
    $page = 'laporankabupaten';
@endphp

@section('content')
    <div class="container-fluid">
        {{-- simple breadcumb --}}
        <x-page-header title="Jumlah Penduduk Per Kabupaten/Kota" icon="file-earmark-text-fill" :breadcrumbs="['Laporan', 'Jumlah Penduduk Per Kabupaten']" />

        <div class="card rounded-0">
            <div class="card-header">
                {{-- header action --}}
                <div class="d-flex">
                    <div class=" flex-grow-1">
                        <a href="{{ route('app.laporan.kabupaten.export') }}" class="btn btn-primary rounded-0 me-2">Export</a>
                    </div>
                    <div class="">
                        <div class="input-group rounded-0">

                            <select name="filter-provinsi" id="filter-provinsi" class="form-select rounded-0">
                                <option value="">Filter Provinsi</option>
                                @foreach ($provinsi as $kprov => $vprov)
                                    <option value="{{ $vprov->id }}">{{ $vprov->nama }}</option>
                                @endforeach
                            </select>

                            <input type="text" aria-label="First name" id="search" placeholder="Pencarian + [Enter]"
                                class="form-control rounded-0">
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                {{-- list Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered" id="table-list">
                        <thead class="table-primary bg-primary">
                            <tr>
                                <th>Kabupaten/Kota</th>
                                <th width="300">Provinsi</th>
                                <th width="300" class="text-end">Jumlah Penduduk</th>
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



@endsection
