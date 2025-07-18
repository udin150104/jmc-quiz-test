@extends('layoutadmin')

@section('title', content: 'Manajemen User')

@php
    $page = 'manajemenuser';
@endphp

@section('content')
    <div class="container-fluid">
        {{-- simple breadcumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "> <i class="bi  bi-people me-2"></i> Manajemen User</li>
            </ol>
        </nav>

        <h3 class="text-muted fst-normal fw-light">Manajemen User</h3>

        <div class="card rounded-0 mt-4">
            <div class="card-header bg-white">
                {{-- header action --}}
                @include('tahapdua.manajemen-user.header')
            </div>
            <div class="card-body p-0 m-0  border-start-0">
                {{-- list Table --}}
                <div class="table-responsive">
                    <table class="table " id="table-list">
                        <thead class="table-light">
                            <tr>
                                <th width="50" class="text-center text-uppercase small fw-light ">No</th>
                                <th width="150" class="text-center text-uppercase small  fw-light">Action</th>
                                <th width="400" class=" text-uppercase  small fw-light sort pointer" data-order="username">Username</th>
                                <th class=" text-uppercase  small fw-light sort pointer" data-order="username">Nama</th>
                                <th  width="400" class=" text-uppercase  small fw-light sort pointer" data-order="email">email</th>
                                <th width="300" class=" text-uppercase  small fw-light sort pointer" data-order="role">Role</th>
                            </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <nav class="mx-2">
                    <ul class="pagination  float-end" id="pagination"></ul>
                </nav>

            </div>
        </div>
    </div>

    {{-- modal form --}}
    @include('tahapdua.manajemen-user.form')
    {{-- modal delete --}}
    @include('tahapdua.deletemodal')
    {{-- lock user modal --}}
    @include('tahapdua.manajemen-user.lockusermodal')

@endsection
