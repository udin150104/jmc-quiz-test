@extends('layoutintro')

@section('title', 'Beranda')

@section('content')

    <div class="row">
        <div class="col-12 col-lg-6 col-sm-12 col-md-12">
            <p>Path: </p>

            <ul class="">
                <li>Controller : <code>app/Http/Controllers/TahapDua/*</code> </li>
                <li>View : <code>resources/views/tahapdua/*</code> </li>
                <li>Model Used: <code>BarangMasuk</code> - <code>BarangMasukItem</code> - <code>Kategori</code> - <code>SubKategori</code> - <code>Roles</code> - <code>User</code></li>
                <li>Seeder Sample : <code>database/seeders/UserSeeder.php</code> </li>
            </ul>

            <p>Route : </p>
            <div class="card">
                <pre class="text-start p-2">
GET|HEAD        application/api/get-sub-kategori-by-kategori .................................................................................. app.api.sub-kategori.by.kategori › TahapDua\ApiKategoriController@getsubkategoribykategori
GET|HEAD        application/barang-masuk .................................................................................................................................... app.barang-masuk.index › TahapDua\BarangMasukControler@index
POST            application/barang-masuk .................................................................................................................................... app.barang-masuk.store › TahapDua\BarangMasukControler@store
GET|HEAD        application/barang-masuk/check-uncheck/{id} ................................................................................................... app.barang-masuk.checkuncheck › TahapDua\BarangMasukControler@checkuncheck
GET|HEAD        application/barang-masuk/create ........................................................................................................................... app.barang-masuk.create › TahapDua\BarangMasukControler@create
GET|HEAD        application/barang-masuk/export ........................................................................................................................... app.barang-masuk.export › TahapDua\BarangMasukControler@export
GET|HEAD        application/barang-masuk/lampiran/download/{path} ............................................................................................ app.barang-masuk.lampiran.download › TahapDua\BarangMasukControler@download
GET|HEAD        application/barang-masuk/{barang_masuk} ....................................................................................................................... app.barang-masuk.show › TahapDua\BarangMasukControler@show
PUT|PATCH       application/barang-masuk/{barang_masuk} ................................................................................................................... app.barang-masuk.update › TahapDua\BarangMasukControler@update
DELETE          application/barang-masuk/{barang_masuk} ................................................................................................................. app.barang-masuk.destroy › TahapDua\BarangMasukControler@destroy
GET|HEAD        application/barang-masuk/{barang_masuk}/cetak ............................................................................................................... app.barang-masuk.cetak › TahapDua\BarangMasukControler@cetak
GET|HEAD        application/barang-masuk/{barang_masuk}/edit .................................................................................................................. app.barang-masuk.edit › TahapDua\BarangMasukControler@edit
GET|HEAD        application/dashboard ................................................................................................................................................. app.dashboard › TahapDua\DashboardController@index
GET|HEAD        application/intro ............................................................................................................................................................... app.intro › TahapDua\TwoController@index
GET|HEAD        application/login .............................................................................................................................................................. app.login › TahapDua\AuthController@index
POST            application/login ...................................................................................................................................................... app.login.process › TahapDua\AuthController@login
POST            application/logout ........................................................................................................................................................... app.logout › TahapDua\AuthController@logout
GET|HEAD        application/manajemen-user ....................................................................................................................................... app.manajemen-user.index › TahapDua\UserControler@index
POST            application/manajemen-user ....................................................................................................................................... app.manajemen-user.store › TahapDua\UserControler@store
GET|HEAD        application/manajemen-user/api/data ............................................................................................................................. app.manajemen-user.data › TahapDua\UserControler@getData
POST            application/manajemen-user/lock-unlock/{manajemen_user} ............................................................................................... app.manajemen-user.lock-unlock › TahapDua\UserControler@lockUnlock
GET|HEAD        application/manajemen-user/{manajemen_user} ........................................................................................................................ app.manajemen-user.show › TahapDua\UserControler@show
PUT|PATCH       application/manajemen-user/{manajemen_user} .................................................................................................................... app.manajemen-user.update › TahapDua\UserControler@update
DELETE          application/manajemen-user/{manajemen_user} .................................................................................................................. app.manajemen-user.destroy › TahapDua\UserControler@destroy
GET|HEAD        application/master/kategori ................................................................................................................................ app.master.kategori.index › TahapDua\KategoriController@index
POST            application/master/kategori ................................................................................................................................ app.master.kategori.store › TahapDua\KategoriController@store
GET|HEAD        application/master/kategori/api/data ...................................................................................................................... app.master.kategori.data › TahapDua\KategoriController@getData
GET|HEAD        application/master/kategori/{kategori} ....................................................................................................................... app.master.kategori.show › TahapDua\KategoriController@show
PUT|PATCH       application/master/kategori/{kategori} ................................................................................................................... app.master.kategori.update › TahapDua\KategoriController@update
DELETE          application/master/kategori/{kategori} ................................................................................................................. app.master.kategori.destroy › TahapDua\KategoriController@destroy
GET|HEAD        application/master/sub-kategori ..................................................................................................................... app.master.sub-kategori.index › TahapDua\SubKategoriController@index
POST            application/master/sub-kategori ..................................................................................................................... app.master.sub-kategori.store › TahapDua\SubKategoriController@store
GET|HEAD        application/master/sub-kategori/api/data ........................................................................................................... app.master.sub-kategori.data › TahapDua\SubKategoriController@getData
GET|HEAD        application/master/sub-kategori/{sub_kategori} ........................................................................................................ app.master.sub-kategori.show › TahapDua\SubKategoriController@show
PUT|PATCH       application/master/sub-kategori/{sub_kategori} .................................................................................................... app.master.sub-kategori.update › TahapDua\SubKategoriController@update
DELETE          application/master/sub-kategori/{sub_kategori} .................................................................................................. app.master.sub-kategori.destroy › TahapDua\SubKategoriController@destroy


                </pre>
            </div>

        </div>
        <div class="col-12 col-lg-6 col-sm-12 col-md-12">
            <p>Preview Soal : </p>
            <iframe src="{{ asset('storage/pdf/Test-Teknis-Programmer-Medium.pdf') }}"
                class="soal p-2"></iframe>
        </div>
    </div>
@endsection
