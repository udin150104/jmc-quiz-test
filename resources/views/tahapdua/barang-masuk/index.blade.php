@extends('layoutadmin')

@section('title', 'Barang Masuk')

@php
    $page = 'indexbarangmasuk';
@endphp

@section('content')
    <div class="container-fluid">
        {{-- simple breadcumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "> <i class="bi bi-box-arrow-in-down me-2"></i> Barang Masuk</li>
            </ol>
        </nav>

        <h3 class="text-muted fst-normal fw-light">Barang Masuk</h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Periksa kembali!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <div class="card rounded-0 mt-4">
            <div class="card-header bg-white">
                {{-- header action --}}
                @include('tahapdua.barang-masuk.header')
            </div>
            <div class="card-body p-0 m-0  border-start-0">
                {{-- list Table --}}
                <div class="table-responsive">
                    <table class="table " id="table-list">
                        <thead class="table-light">
                            <tr>
                                <th width="50" class="text-center text-uppercase small fw-light ">No</th>
                                <th width="150" class="text-center text-uppercase small fw-light">Action</th>
                                <th width="200" class="text-start text-uppercase small fw-light sort pointer">
                                    @php
                                        $query = request()->query();
                                        $query['sort'] = request()->query('sort', 'ASC') === 'ASC' ? 'DESC' : 'ASC';
                                        $query['orderBy'] = 'odtanggal';
                                    @endphp
                                    <a href="{{ route('app.barang-masuk.index', $query) }}"
                                        class="text-decoration-none text-dark">
                                        @if (request('orderBy') === 'odtanggal')
                                            <i
                                                class="bi {{ request('sort', 'ASC') === 'ASC' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        @endif
                                        Tanggal
                                    </a>
                                </th>
                                <th width="150" class="text-start text-uppercase small fw-light sort pointer">

                                    @php
                                        $query = request()->query();
                                        $query['sort'] = request()->query('sort', 'ASC') === 'ASC' ? 'DESC' : 'ASC';
                                        $query['orderBy'] = 'odasal_barang';
                                    @endphp
                                    <a href="{{ route('app.barang-masuk.index', $query) }}"
                                        class="text-decoration-none text-dark">
                                        @if (request('orderBy') === 'odasal_barang')
                                            <i
                                                class="bi {{ request('sort', 'ASC') === 'ASC' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        @endif
                                        Asal Barang
                                    </a>

                                </th>
                                <th width="150" class="text-start text-uppercase small fw-light">Penerima</th>
                                <th width="150" class="text-start text-uppercase small fw-light">UNIT</th>
                                <th class=" text-uppercase  small fw-light ">Kode</th>
                                <th class=" text-uppercase  small fw-light ">Nama </th>
                                <th class=" text-uppercase  small fw-light ">Harga </th>
                                <th class=" text-uppercase  small fw-light ">Jumlah </th>
                                <th class=" text-uppercase  small fw-light sort pointer">
                                    @php
                                        $query = request()->query();
                                        $query['sort'] = request()->query('sort', 'ASC') === 'ASC' ? 'DESC' : 'ASC';
                                        $query['orderBy'] = 'odtotal';
                                    @endphp
                                    <a href="{{ route('app.barang-masuk.index', $query) }}"
                                        class="text-decoration-none text-dark">
                                        @if (request('orderBy') === 'odtotal')
                                            <i
                                                class="bi {{ request('sort', 'ASC') === 'ASC' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        @endif
                                        Total
                                    </a>
                                </th>
                                <th class=" text-uppercase  small fw-light ">Status </th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($barangMasuk as $index => $bm)
                                <tr>
                                    <td class="text-center {{ $bm->items->count() > 1 ? 'border-bottom-0' : '' }}">
                                        {{ $barangMasuk->firstItem() + $index }}</td>
                                    <td class="text-center {{ $bm->items->count() > 1 ? 'border-bottom-0' : '' }}">
                                        <a href="{{ route('app.barang-masuk.edit', array_merge(['barang_masuk' => $bm->id], request()->query())) }}"
                                            class="btn btn-sm rounded-0">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('app.barang-masuk.cetak', [$bm->id]) }}" target="_blank"
                                            class="btn btn-sm rounded-0">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </a>
                                        <form
                                            action="{{ route('app.barang-masuk.destroy', array_merge(['barang_masuk' => $bm->id], request()->query())) }}"
                                            method="POST" class="d-inline delete-form" data-id="{{ $bm->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm text-danger rounded-0 btn-show-delete-modal"
                                                data-id="{{ $bm->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class=" {{ $bm->items->count() > 1 ? 'border-bottom-0' : '' }}">
                                        {{ \Carbon\Carbon::parse($bm->created_at)->format('d/m/Y H:i:s') }}</td>
                                    <td class=" {{ $bm->items->count() > 1 ? 'border-bottom-0' : '' }}">
                                        {{ $bm->suplier }}
                                    </td>
                                    <td class=" {{ $bm->items->count() > 1 ? 'border-bottom-0' : '' }}">
                                        {{ $bm->user?->name }}</td>
                                    <td class=" {{ $bm->items->count() > 1 ? 'border-bottom-0' : '' }}">Gudang Utama</td>
                                    @foreach ($bm->items as $k => $vl)
                                        @if ($k === 0)
                                            <td>{{ 'ATK' . str_pad($k + 1, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $vl->nama }}</td>
                                            <td>{{ number_format($vl->price, 0, ',', '.') }}</td>
                                            <td>{{ $vl->qty . ' ' . $vl->satuan }}</td>
                                            @php
                                                $total = 0;
                                                if (
                                                    is_numeric(value: $vl->qty) &&
                                                    is_numeric(value: $vl->price) &&
                                                    $vl->price > 0 &&
                                                    $vl->qty > 0
                                                ) {
                                                    $total = $vl->qty * $vl->price;
                                                }
                                            @endphp
                                            <td>{{ number_format($total, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ route('app.barang-masuk.checkuncheck', [$vl->id]) }}"
                                                    type="button" class="btn btn-sm rounded-0 ">
                                                    @if ($vl->status > 0)
                                                        <i class="bi bi-check2-circle text-success"></i>
                                                    @else
                                                        <i class="bi bi-dash-circle-dotted"></i>
                                                    @endif
                                                </a>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                                @if ($bm->items->count() > 1)
                                    <tr>
                                        <td colspan="6"></td>
                                        @foreach ($bm->items as $k => $vl)
                                            @if ($k > 0)
                                                <td>{{ 'ATK' . str_pad($k + 1, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $vl->nama }}</td>
                                                <td>{{ number_format($vl->price, 0, ',', '.') }}</td>
                                                <td>{{ $vl->qty . ' ' . $vl->satuan }}</td>
                                                @php
                                                    $total = 0;
                                                    if (
                                                        is_numeric(value: $vl->qty) &&
                                                        is_numeric(value: $vl->price) &&
                                                        $vl->price > 0 &&
                                                        $vl->qty > 0
                                                    ) {
                                                        $total = $vl->qty * $vl->price;
                                                    }
                                                @endphp
                                                <td>{{ number_format($total, 0, ',', '.') }}</td>
                                                <td>
                                                    <a href="{{ route('app.barang-masuk.checkuncheck', [$vl->id]) }}"
                                                        type="button" class="btn btn-sm rounded-0 ">
                                                        @if ($vl->status > 0)
                                                            <i class="bi bi-check2-circle text-success"></i>
                                                        @else
                                                            <i class="bi bi-dash-circle-dotted"></i>
                                                        @endif
                                                    </a>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <nav class="mx-2">
                    @if ($barangMasuk->total() < $barangMasuk->perPage())
                        @include('tahapdua.nodatapagination')
                    @else
                        {{ $barangMasuk->links('vendor.pagination.bootstrap-5-custom') }}
                    @endif
                </nav>

            </div>
        </div>
    </div>


    {{-- modal delete --}}
    @include('tahapdua.deletemodal')

@endsection
