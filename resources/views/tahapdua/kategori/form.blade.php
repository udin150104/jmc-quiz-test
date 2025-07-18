<div class="modal fade " id="form-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header  rounded-0 bg-light">
                <h1 class="modal-title fs-5 text-dark" id="title-form">Form</h1>
            </div>
            <div class="modal-body">
                <form action="" id="form-data">
                    <div class="mb-3 ">
                        <label for="kode" class="col-form-label">Kode Kategori<sup class="text-danger">*</sup></label>
                        <div class="col-md-6 col-lg-3 col-sm-12">
                            <input type="text" class="form-control rounded-0 " id="kode" name="kode">
                        </div>
                        <div id="kode-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="col-form-label">Nama Kategori<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control rounded-0" id="nama" name="nama">
                        <div id="nama-help" class="form-text text-danger help"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light rounded-0">
                <button type="button" class="btn rounded-0 btn-batal">Batal</button>
                <button type="button" id="submit-action" class="btn btn-dark rounded-0">Simpan</button>
            </div>
        </div>
    </div>
</div>
