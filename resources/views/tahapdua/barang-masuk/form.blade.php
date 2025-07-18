@extends('layoutadmin')

@section('title', 'Barang Masuk')

@php
    $page = 'form_barangmasuk';
@endphp
@section('content')
    <div class="container-fluid">

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

        {{-- @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Periksa kembali!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif --}}

        <div class="card rounded-0">
            <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method($method)
                <div class="card-header bg-light">
                    <h5 class="text-uppercase fw-light">Informasi Umum</h5>
                </div>
                <div class="card-body ">
                    <div class="mb-3 row">
                        <label for="operator" class="col-form-label">Operator<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12 col-lg-3 col-md-6">
                            @if (auth()->user()->roles->first()->nama === 'Administrator')
                                <select name="operator" id="operator" class="form-select rounded-0">
                                    <option value="" hidden>Pilih Operator</option>
                                    @php
                                        $valoperator = old(
                                            'operator',
                                            $method === 'PUT' ? $barang_masuk->user_id : null,
                                        );
                                    @endphp
                                    @foreach ($operator as $k => $v)
                                        <option value="{{ $v->id }}" {{ $valoperator == $v->id ? 'selected' : '' }}>
                                            {{ $v->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="hidden" id="operator" name="operator" value="{{ auth()->user()->id }}">
                                <input type="text"
                                    class="form-control form-control-plaintext bg-white text-muted rounded-0 " disabled
                                    value="{{ auth()->user()->name }}">
                            @endif
                        </div>
                        @error('operator')
                            <div class="form-text text-danger help">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="kategori" class="col-form-label">Kategori<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12 col-lg-3 col-md-6">
                            <select name="kategori" id="kategori" class="form-select rounded-0">
                                @php
                                    $valkategori = old(
                                        'kategori',
                                        $method === 'PUT' ? $barang_masuk->kategori_id : null,
                                    );
                                @endphp
                                <option value="" hidden>Pilih Kategori</option>
                                @foreach ($kategori as $k => $v)
                                    <option value="{{ $v->id }}" {{ $valkategori == $v->id ? 'selected' : '' }}>
                                        {{ $v->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('kategori')
                            <div class="form-text text-danger help">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <div class="col-sm-12 col-lg-3 col-md-6 ">
                            <label for="subkategori" class="col-form-label">Sub Kategori<sup
                                    class="text-danger">*</sup></label>
                            <select name="subkategori" id="subkategori" class="form-select rounded-0">
                                @php
                                    $valsubkategori = old(
                                        'subkategori',
                                        $method === 'PUT' ? $barang_masuk->sub_kategori_id : null,
                                    );
                                @endphp
                                <option value="" hidden>Pilih Sub kategori</option>
                                @if (isset($subkategori))
                                    @foreach ($subkategori as $sub)
                                        <option value="{{ $sub->id }}" data-limit="{{ $sub->limit_price }}"
                                            {{ $valsubkategori == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->nama }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Pilih Kategori Terlebih Dahulu</option>
                                @endif
                            </select>
                            @error('subkategori')
                                <div class="form-text text-danger help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-lg-3 col-md-6">
                            <label for="batas" class="col-form-label">Batas barang</label>
                            <input type="text"
                                class="form-control form-control-plaintext bg-white text-muted rounded-0 px-2" disabled
                                id="batas" name="batas" placeholder="Pilih Kategori Terlebih Dahulu"
                                value="{{ $pricebatas }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="asal" class="col-form-label">Asal Barang<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12 col-lg-6 col-md-6">
                            @php
                                $valasal = old('asal', $method === 'PUT' ? $barang_masuk->suplier : null);
                            @endphp
                            <input type="text" class="form-control rounded-0" id="asal" name="asal"
                                value="{{ $valasal }}">
                        </div>
                        @error('asal')
                            <div class="form-text text-danger help">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <div class="col-sm-12 col-lg-3 col-md-6 ">
                            <label for="no_surat" class="col-form-label">Nomor Surat</label>
                            @php
                                $valno_surat = old('no_surat', $method === 'PUT' ? $barang_masuk->no_surat : null);
                            @endphp
                            <input type="text" class="form-control rounded-0" id="no_surat" name="no_surat"
                                value="{{ $valno_surat }}">
                            @error('no_surat')
                                <div class="form-text text-danger help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-lg-3 col-md-6 ">
                            <label for="lampiran" class="col-form-label">Lampiran</label>
                            <input type="file" class="form-control rounded-0" id="lampiran" name="lampiran">
                            @if ($method === 'PUT')
                                <small class="form-text text-muted small">(Kosongkan jika tidak ingin menganti file
                                    lampiran)</small>
                            @endif
                            @error('lampiran')
                                <div class="form-text text-danger help">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (
                            $method === 'PUT' &&
                                !is_null($barang_masuk->lampiran) &&
                                $barang_masuk->lampiran !== '' &&
                                !empty($barang_masuk->lampiran))
                            <div class="col-sm-12 col-lg-3 col-md-6 ">
                                <label for="lampiranfile" class="col-form-label">&nbsp;</label>
                                <a href="{{ route('app.barang-masuk.lampiran.download', $barang_masuk->lampiran) }}" class="text-info form-control"> <i
                                        class="bi bi-file-earmark-arrow-down"></i> Download File </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-header bg-light">
                    <h5 class="text-uppercase fw-light">Informasi Barang</h5>
                </div>
                <div class="card-body table-responsive">
                    @include('tahapdua.barang-masuk.errortable')
                    
                    <table class="w-100" id="list-item">
                        <thead>
                            <tr>
                                <td class="text-start text-uppercase small fw-bolder ">Nama Barang<sup
                                        class="text-danger">*</sup></td>
                                <td width="300" class="text-start text-uppercase small fw-bolder ">Harga (Rp)<sup
                                        class="text-danger">*</sup></td>
                                <td width="100" class="text-start text-uppercase small fw-bolder ">Jumlah<sup
                                        class="text-danger">*</sup></td>
                                <td width="100" class="text-start text-uppercase small fw-bolder ">Satuan<sup
                                        class="text-danger">*</sup></td>
                                <td width="300" class="text-start text-uppercase small fw-bolder ">Total<sup
                                        class="text-danger">*</sup></td>
                                <td width="150" class="text-start text-uppercase small fw-bolder ">Tgl. Ekspired</td>
                                <td width="50" class="text-start text-uppercase small fw-bolder "></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $arr = [];

                                if ($method === 'PUT') {
                                    $nama_item_arr = old(
                                        'nama_item',
                                        array_column($barang_masuk->items->toArray(), 'nama'),
                                    );
                                    $harga_arr = old('harga', array_column($barang_masuk->items->toArray(), 'price'));
                                    $jumlah_arr = old(
                                        'jumlah',
                                        array_column($barang_masuk->items->toArray(), 'qty'),
                                    );
                                    $satuan_arr = old(
                                        'satuan',
                                        array_column($barang_masuk->items->toArray(), 'satuan'),
                                    );
                                    $tgl_expired_arr = old(
                                        'tgl_expired',
                                        array_column($barang_masuk->items->toArray(), 'tgl_expired'),
                                    );
                                } else {
                                    $nama_item_arr = old('nama_item', []);
                                    $harga_arr = old('harga', []);
                                    $jumlah_arr = old('jumlah', []);
                                    $satuan_arr = old('satuan', []);
                                    $tgl_expired_arr = old('tgl_expired', []);
                                }

                                $count = max(
                                    count($nama_item_arr),
                                    count($harga_arr),
                                    count($jumlah_arr),
                                    count($satuan_arr),
                                    count($tgl_expired_arr),
                                );
                                if ($count === 0) {
                                    $count = 1;
                                } // Minimal 1 baris
                            @endphp
                            @for ($i = 0; $i < $count; $i++)
                                @php
                                    $nama_item = $nama_item_arr[$i] ?? '';
                                    $harga = $harga_arr[$i] ?? '';
                                    $jumlah = $jumlah_arr[$i] ?? 1;
                                    $satuan = $satuan_arr[$i] ?? '';
                                    $tgl_expired = $tgl_expired_arr[$i] ?? '';

                                    $qty = is_numeric($jumlah) ? (int) $jumlah : 0;
                                    $price = is_numeric($harga) ? (int) $harga : 0;
                                    $total = $qty * $price;

                                    // Format harga & total ke format Rupiah (jika numeric)
                                    $formatRupiah = fn($angka) => is_numeric($angka)
                                        ? 'Rp. ' . number_format($angka, 0, ',', '.')
                                        : $angka;
                                @endphp

                                <tr>
                                    <td class="pe-2 pt-2">
                                        <input type="text" class="form-control rounded-0" name="nama_item[]"
                                            value="{{ $nama_item }}">
                                    </td>
                                    <td class="pe-2 pt-2">
                                        <input type="text" class="form-control text-end rounded-0 currency"
                                            placeholder="Rp." name="harga[]" value="{{ $formatRupiah($harga) }}">
                                    </td>
                                    <td class="pe-2 pt-2">
                                        <input type="number" class="form-control rounded-0" name="jumlah[]"
                                            min="1" value="{{ $jumlah }}">
                                    </td>
                                    <td class="pe-2 pt-2">
                                        <input type="text" class="form-control rounded-0" name="satuan[]"
                                            value="{{ $satuan }}">
                                    </td>
                                    <td class="pe-2 pt-2">
                                        <input type="text"
                                            class="form-control form-control-plaintext px-2 text-end currency rounded-0"
                                            disabled placeholder="Rp." name="total[]"
                                            value="{{ $formatRupiah($total) }}">
                                    </td>
                                    <td class="pe-2 pt-2">
                                        <input type="text" class="form-control rounded-0 datepicker"
                                            name="tgl_expired[]" value="{{ $tgl_expired }}">
                                    </td>
                                    <td>
                                        @if ($i == 0)
                                            <button type="button" id="add-row-table" class="btn rounded-0">
                                                <i class="bi bi-plus-circle"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn rounded-0 btn-remove-row">
                                                <i class="bi bi-x-circle-fill text-danger"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endfor

                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-light rounded-0">
                    <a href="{{ route('app.barang-masuk.index', request()->query()) }}"
                        class="btn btn-link text-decoration-none text-secondary"><i class="bi bi-arrow-left"></i>
                        Kembali</a>
                    <button type="submit" id="submit-action" class="btn btn-dark rounded-0">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection
