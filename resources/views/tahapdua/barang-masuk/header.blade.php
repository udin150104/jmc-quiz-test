<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-6 ">
        <a href="{{ route('app.barang-masuk.create', request()->query()) }}" type="button" class="btn btn-dark" id="btn-add"> <i class="bi bi-plus me-1"></i> Tambah Data</a>
        <a href="{{ route('app.barang-masuk.export',request()->except('page')) }}" type="button" class="btn btn-success"> <i class="bi bi-file-earmark-spreadsheet"></i> Export</a>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-6">
        <form action="{{ route('app.barang-masuk.index') }}" method="GET" class="mt-2">
            <div class="input-group rounded-0">

                {{-- Kategori --}}
                <select name="filter-kategori" id="filter-kategori" class="form-select rounded-0 me-2">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategori as $vkategori)
                        <option value="{{ $vkategori->id }}"
                            {{ request()->input('filter-kategori') == $vkategori->id ? 'selected' : '' }}>
                            {{ $vkategori->nama }}
                        </option>
                    @endforeach
                </select>

                {{-- Sub Kategori --}}
                <select name="filter-sub-kategori" id="filter-sub-kategori" class="form-select rounded-0 me-2">
                    <option value="">Semua Sub Kategori</option>
                    @if($subkategorilist)
                    @foreach ($subkategorilist as $val)
                        <option value="{{ $val->id }}"
                            {{ request()->input('filter-sub-kategori') == $val->id ? 'selected' : '' }}>
                            {{ $val->nama }}
                        </option>
                    @endforeach
                    @endif
                </select>

                {{-- Tahun --}}
                <select name="filter-tahun" id="filter-tahun" class="form-select rounded-0 me-2">
                    <option value="">Semua Tahun</option>
                    @foreach ($tahun as $v)
                        <option value="{{ $v }}"
                            {{ request()->input('filter-tahun') == $v ? 'selected' : '' }}>
                            {{ $v }}
                        </option>
                    @endforeach
                </select>

                {{-- Pencarian --}}
                <input type="text" name="search" id="search" placeholder="Cari data ..."
                    class="form-control search me-2" value="{{ request()->input('search') }}">

                <button type="submit" class="btn btn-secondary bg-secondary-subtle border-secondary-subtle rounded-0"
                    id="btn-search">
                    <i class="bi bi-search text-dark"></i>
                </button>
            </div>
        </form>

    </div>
</div>
