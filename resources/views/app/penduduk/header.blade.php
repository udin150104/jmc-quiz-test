<div class="d-flex">
    <div class=" flex-grow-1">
        <button type="button" class="btn btn-primary rounded-0 me-2 " id="btn-add">Tambah</button>
    </div>
    <div class="">
        <div class="input-group rounded-0">
            <select name="filter-provinsi" id="filter-provinsi" class="form-select rounded-0">
                <option value="">Provinsi</option>
                @foreach ($provinsi as $kprov => $vprov)
                    <option value="{{ $vprov->id }}">{{ $vprov->nama }}</option>
                @endforeach
            </select>
            <select name="filter-kabupaten" id="filter-kabupaten" class="form-select rounded-0 ms-2">
                <option value="">Kabupaten</option>
            </select>
            <input type="text" aria-label="First name" id="search" placeholder="Pencarian + [enter]"
                class="form-control rounded-0 ms-2">
            <button type="button" class="btn btn-sm btn-outline-danger rounded-0 me-2 ms-2" id="btn-reset-filter">Hapus
                Filter</button>
        </div>
    </div>
</div>
