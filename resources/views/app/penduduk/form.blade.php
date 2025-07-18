<div class="modal fade" id="form-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header  rounded-0 bg-primary">
                <h1 class="modal-title fs-5 text-white" id="title-form">Form Data</h1>
            </div>
            <div class="modal-body">
                <form action="" id="form-data">
                    <div class="mb-3">
                        <label for="nik" class="col-form-label">NIK<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control rounded-0" id="nik" name="nik">
                        <div id="nik-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="col-form-label">Nama<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control rounded-0" id="nama" name="nama">
                        <div id="nama-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="col-form-label">Tanggal Lahir<sup
                                class="text-danger">*</sup></label>
                        <input type="text" class="form-control rounded-0 datepicker-max-now" id="tanggal_lahir"
                            name="tanggal_lahir">
                        <div id="tanggal_lahir-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Jenis Kelamin<sup class="text-danger">*</sup></label>
                        <div class="px-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1"
                                    value="L">
                                <label class="form-check-label" for="jenis_kelamin1">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2"
                                    value="P">
                                <label class="form-check-label" for="jenis_kelamin2">Perempuan</label>
                            </div>
                        </div>
                        <div id="jenis_kelamin-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3">
                        <label for="provinsi" class="col-form-label">Provinsi <sup class="text-danger">*</sup></label>
                        <select name="provinsi" id="provinsi" class="form-select  rounded-0">
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinsi as $kprov => $vprov)
                                <option value="{{ $vprov->id }}">{{ $vprov->nama }}</option>
                            @endforeach
                        </select>
                        <div id="provinsi-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3">
                        <label for="kabupaten" class="col-form-label">Kabupaten <sup class="text-danger">*</sup></label>
                        <select name="kabupaten" id="kabupaten" class="form-select  rounded-0">
                            <option value="">Pilih Kabupaten</option>
                        </select>
                        <div id="kabupaten-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="col-form-label">Alamat <sup class="text-danger">*</sup></label>
                        <textarea name="alamat" id="alamat" class="form-control"></textarea>
                        <div id="alamat-help" class="form-text text-danger help"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer  rounded-0">
                <button type="button" class="btn btn-secondary rounded-0" id="btn-batal">Batal</button>
                <button type="button" id="submit-action" class="btn btn-primary rounded-0">Simpan</button>
            </div>
        </div>
    </div>
</div>
