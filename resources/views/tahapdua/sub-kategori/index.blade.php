@extends('layoutadmin')

@section('title', 'Master Data Sub Kategori')

@php
    $page = 'subkategori';
@endphp

@section('content')
    <div class="container-fluid">
        {{-- simple breadcumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "> <i class="bi bi-folder2-open me-2"></i> Master Data</li>
                <li class="breadcrumb-item text-muted"> Sub Kategori</li>
            </ol>
        </nav>

        <h3 class="text-muted fst-normal fw-light">Sub Kategori</h3>

        <div class="card rounded-0 mt-4">
            <div class="card-header bg-white">
                {{-- header action --}}
                @include('tahapdua.sub-kategori.header')
            </div>
            <div class="card-body p-0 m-0  border-start-0">
                {{-- list Table --}}
                <div class="table-responsive">
                    <table class="table " id="table-list">
                        <thead class="table-light">
                            <tr>
                                <th width="50" class="text-center text-uppercase small fw-light">No</th>
                                <th width="150" class="text-center text-uppercase small  fw-light">Action</th>
                                <th width="300" class=" text-uppercase  small fw-light sort pointer" data-order="kategori">Kategori Barang</th>
                                <th class=" text-uppercase  small fw-light sort pointer" data-order="nama">Sub Kategori Barang</th>
                                <th width="200"  class=" text-uppercase text-end small fw-light sort pointer" data-order="harga" >Batas harga (rp)</th>
                            </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <nav class="mx-2">
                    <ul class="pagination float-end" id="pagination"></ul>
                </nav>

            </div>
        </div>
    </div>

    {{-- modal form --}}
    @include('tahapdua.sub-kategori.form')
    {{-- modal delete --}}
    @include('tahapdua.deletemodal')

@endsection
