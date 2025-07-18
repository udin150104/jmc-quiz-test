<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TahapDua\BarangMasukControler;
use App\Http\Controllers\TahapDua\ApiKategoriController;
use App\Http\Middleware\{IsAuthenticated, IsBanned, IsGuest, NotAllowedToOperator};
use App\Http\Controllers\TahapDua\{TwoController, AuthController, DashboardController, KategoriController, SubKategoriController, UserControler};
use App\Http\Controllers\Application\{ApiWilayahController, HomeController, PendudukController, ProvinsiController, KabupatenController, LaporanKabupatenController, LaporanProvinsiController};


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::group(['prefix' => 'application', 'as' => 'app.'], function () {
    /**
     * -----------------------------------------------------------------------------------------------------------
     * Test Kemampuan Dasar I
     * -----------------------------------------------------------------------------------------------------------
     */
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::group(['prefix' => 'referensi', 'as' => 'ref.'], function () {
        /**
         * Provinsi
         */
        Route::resource('provinsi', ProvinsiController::class)->except(['create', 'edit']);
        Route::get('provinsi/api/data', [ProvinsiController::class, 'getData'])->name('provinsi.data');

        /**
         * Kabupaten
         */
        Route::resource('kabupaten', KabupatenController::class)->except(['create', 'edit']);
        Route::get('kabupaten/api/data', [KabupatenController::class, 'getData'])->name('kabupaten.data');
    });
    Route::group(['prefix' => 'laporan', 'as' => 'laporan.'], function () {
        /**
         * Provinsi
         */
        Route::resource('provinsi', LaporanProvinsiController::class)->only(['index']);
        Route::get('provinsi/api/data', [LaporanProvinsiController::class, 'getData'])->name('provinsi.data');
        Route::get('provinsi/export', [LaporanProvinsiController::class, 'export'])->name('provinsi.export');
        /**
         * Kabupaten
         */
        Route::resource('kabupaten', LaporanKabupatenController::class)->only(['index']);
        Route::get('kabupaten/api/data', [LaporanKabupatenController::class, 'getData'])->name('kabupaten.data');
        Route::get('kabupaten/export', [LaporanKabupatenController::class, 'export'])->name('kabupaten.export');
    });
    /**
     * Penduduk
     */
    Route::resource('penduduk', PendudukController::class)->except(['create', 'edit']);
    Route::get('penduduk/api/data', [PendudukController::class, 'getData'])->name('penduduk.data');
    /**
     * Api kabupaten by provinsi
     */
    Route::get('api/get-kabupaten-by-provinsi', [ApiWilayahController::class, 'getKabupatenByProvinsi'])->name('api.kabupaten.by.provinsi');
    Route::get('api/get-sub-kategori-by-kategori', [ApiKategoriController::class, 'getsubkategoribykategori'])->name('api.sub-kategori.by.kategori');


    /**
     * -----------------------------------------------------------------------------------------------------------
     * Test Kemampuan Dasar II
     * -----------------------------------------------------------------------------------------------------------
     */
    Route::get('intro', [TwoController::class, 'index'])->name('intro');
    Route::middleware([IsGuest::class])->group(function () {
        Route::get('login', [AuthController::class, 'index'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.process');
    });

    Route::middleware([IsAuthenticated::class, IsBanned::class])->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        /**
         * Master Data 
         */
        Route::group(['prefix' => 'master', 'as' => 'master.', 'middleware' => [NotAllowedToOperator::class] ], function () {
            /** Kategori */
            Route::resource('kategori', KategoriController::class)->except(['create', 'edit']);
            Route::get('kategori/api/data', [KategoriController::class, 'getData'])->name('kategori.data');
            /** Sub Kategori */
            Route::resource('sub-kategori', SubKategoriController::class)->except(['create', 'edit']);
            Route::get('sub-kategori/api/data', [SubKategoriController::class, 'getData'])->name('sub-kategori.data');
        });
        /** Manajemen User */
        Route::resource('manajemen-user', UserControler::class)->except(['create', 'edit'])->middleware([NotAllowedToOperator::class]);
        Route::get('manajemen-user/api/data', [UserControler::class, 'getData'])->name('manajemen-user.data')->middleware([NotAllowedToOperator::class]);
        Route::post('manajemen-user/lock-unlock/{manajemen_user}', [UserControler::class, 'lockUnlock'])->name('manajemen-user.lock-unlock')->middleware([NotAllowedToOperator::class]);
        /** Barang Masuk */
        Route::get('barang-masuk/export', [BarangMasukControler::class, 'export'])->name('barang-masuk.export');
        Route::get('barang-masuk/check-uncheck/{id}', [BarangMasukControler::class, 'checkuncheck'])->name('barang-masuk.checkuncheck');
        Route::get('barang-masuk/{barang_masuk}/cetak', [BarangMasukControler::class, 'cetak'])->name('barang-masuk.cetak');
        Route::get('barang-masuk/lampiran/download/{path}', [BarangMasukControler::class, 'download'])->where('path', '.*')->name('barang-masuk.lampiran.download');
        Route::resource('barang-masuk',  BarangMasukControler::class);
    });
});
