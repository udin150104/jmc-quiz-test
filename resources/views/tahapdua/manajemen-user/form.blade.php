<div class="modal fade " id="form-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header  rounded-0 bg-light">
                <h1 class="modal-title fs-5 text-dark" id="title-form">Form</h1>
            </div>
            <div class="modal-body">
                <form action="" id="form-data">
                    <div class="mb-3">
                        <label for="role" class="col-form-label">Role<sup class="text-danger">*</sup></label>
                        <select name="role" id="role" class="form-select rounded-0">
                        <option value="" hidden>Pilih Peran</option>
                        @foreach ($role as $krole => $vrole)
                            <option value="{{ $vrole->id }}">{{ $vrole->nama }}</option>
                        @endforeach
                        </select>
                        <div id="role-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3 ">
                        <label for="username" class="col-form-label">Username<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control rounded-0 " id="username" name="username">
                        <div id="username-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3 ">
                        <label for="password" class="col-form-label">Password<sup class="text-danger">*</sup></label>
                        <small id="password-info" class="form-text text-muted small d-none">(Kosongkan jika tidak ada perubahan password)</small>
                        <input type="password" class="form-control rounded-0 " id="password" name="password">
                        <div id="password-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="col-form-label">Nama<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control rounded-0" id="name" name="name">
                        <div id="name-help" class="form-text text-danger help"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="col-form-label">Email<sup class="text-danger">*</sup></label>
                        <input type="email" class="form-control rounded-0" id="email" name="email">
                        <div id="email-help" class="form-text text-danger help"></div>
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
