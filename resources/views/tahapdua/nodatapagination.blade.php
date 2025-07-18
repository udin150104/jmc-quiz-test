<nav class="d-flex justify-items-center justify-content-between">
    <div class="d-flex justify-content-between flex-fill d-sm-none">
        <ul class="pagination">
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link text-dark"><i class="bi bi-caret-left"></i>
                        Sebelumnya</span>
            </li>
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link text-dark">Selanjutnya <i
                            class="bi bi-caret-right"></i></span>
            </li>
        </ul>
    </div>

    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
        <div>
            {{-- <p class="small text-muted">
                Tidak ada data ditampilkan
            </p> --}}
        </div>

        <div>
            <ul class="pagination">
                <li class="page-item disabled text-dark" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link text-dark" aria-hidden="true"><i class="bi bi-caret-left"></i>
                        Sebelumnya</span>
                </li>
                <li class="page-item active active-page " aria-current="page"><span class="page-link ">1</span></li>
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link text-dark" aria-hidden="true">Selanjutnya <i
                            class="bi bi-caret-right"></i></span>
                </li>
            </ul>
        </div>
    </div>
</nav>
