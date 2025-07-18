<div class="row">
    <div class="col-6 ">
        <button type="button" class="btn btn-dark" id="btn-add"> <i class="bi bi-plus me-1"></i> Tambah
            Data</button>
    </div>
    <div class="col-6">
        <div class="input-group rounded-0">
            <select name="filter-role" id="filter-role" class="form-select rounded-0 me-2">
                <option value="">Semua Role</option>
                @foreach ($role as $krole => $vrole)
                    <option value="{{ $vrole->id }}">{{ $vrole->nama }}</option>
                @endforeach
            </select>
            <input type="text" name="search" id="search" placeholder="Cari data ..."
                class="form-control search ">
            <button class="btn btn-secondary bg-secondary-subtle border-secondary-subtle" type="button"
                id="btn-search"><i class="bi bi-search text-dark"></i></button>
        </div>
    </div>
</div>
