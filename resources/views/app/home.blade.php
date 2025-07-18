@extends('layout')

@section('title', 'Beranda')

@section('content')

    <div class="row">
        <div class="col-12 col-lg-6 col-sm-12 col-md-12">
            <p>Path: </p>

            <ul class="">
                <li>Controller : <code>app/Http/Controllers/Application/*</code> </li>
                <li>View : <code>resources/views/app/*</code> </li>
                <li>Model Used: <code>Kabupaten</code> - <code>Penduduk</code> - <code>Provinsi</code> </li>
                <li>Seeder Sample : <code>database/seeders/MasterDataSeeder.php</code> </li>
            </ul>

            <p>Route : </p>
            <div class="card">
                <pre class="text-start p-2">
GET|HEAD        application .................................................................................................................................................................. app.home › Application\HomeController@index
GET|HEAD        application/api/get-kabupaten-by-provinsi ........................................................................................ app.api.kabupaten.by.provinsi › Application\ApiWilayahController@getKabupatenByProvinsi
GET|HEAD        application/laporan/kabupaten ................................................................................................................. app.laporan.kabupaten.index › Application\LaporanKabupatenController@index
GET|HEAD        application/laporan/kabupaten/api/data ....................................................................................................... app.laporan.kabupaten.data › Application\LaporanKabupatenController@getData
GET|HEAD        application/laporan/kabupaten/export ........................................................................................................ app.laporan.kabupaten.export › Application\LaporanKabupatenController@export
GET|HEAD        application/laporan/provinsi .................................................................................................................... app.laporan.provinsi.index › Application\LaporanProvinsiController@index
GET|HEAD        application/laporan/provinsi/api/data .......................................................................................................... app.laporan.provinsi.data › Application\LaporanProvinsiController@getData
GET|HEAD        application/laporan/provinsi/export ........................................................................................................... app.laporan.provinsi.export › Application\LaporanProvinsiController@export
GET|HEAD        application/penduduk ........................................................................................................................................... app.penduduk.index › Application\PendudukController@index
POST            application/penduduk ........................................................................................................................................... app.penduduk.store › Application\PendudukController@store
GET|HEAD        application/penduduk/api/data ................................................................................................................................. app.penduduk.data › Application\PendudukController@getData
GET|HEAD        application/penduduk/{penduduk} .................................................................................................................................. app.penduduk.show › Application\PendudukController@show
PUT|PATCH       application/penduduk/{penduduk} .............................................................................................................................. app.penduduk.update › Application\PendudukController@update
DELETE          application/penduduk/{penduduk} ............................................................................................................................ app.penduduk.destroy › Application\PendudukController@destroy
GET|HEAD        application/referensi/kabupaten .......................................................................................................................... app.ref.kabupaten.index › Application\KabupatenController@index
POST            application/referensi/kabupaten .......................................................................................................................... app.ref.kabupaten.store › Application\KabupatenController@store
GET|HEAD        application/referensi/kabupaten/api/data ................................................................................................................ app.ref.kabupaten.data › Application\KabupatenController@getData
GET|HEAD        application/referensi/kabupaten/{kabupaten} ................................................................................................................ app.ref.kabupaten.show › Application\KabupatenController@show
PUT|PATCH       application/referensi/kabupaten/{kabupaten} ............................................................................................................ app.ref.kabupaten.update › Application\KabupatenController@update
DELETE          application/referensi/kabupaten/{kabupaten} .......................................................................................................... app.ref.kabupaten.destroy › Application\KabupatenController@destroy
GET|HEAD        application/referensi/provinsi ............................................................................................................................. app.ref.provinsi.index › Application\ProvinsiController@index
POST            application/referensi/provinsi ............................................................................................................................. app.ref.provinsi.store › Application\ProvinsiController@store
GET|HEAD        application/referensi/provinsi/api/data ................................................................................................................... app.ref.provinsi.data › Application\ProvinsiController@getData
GET|HEAD        application/referensi/provinsi/{provinsi} .................................................................................................................... app.ref.provinsi.show › Application\ProvinsiController@show
PUT|PATCH       application/referensi/provinsi/{provinsi} ................................................................................................................ app.ref.provinsi.update › Application\ProvinsiController@update
DELETE          application/referensi/provinsi/{provinsi} .............................................................................................................. app.ref.provinsi.destroy › Application\ProvinsiController@destroy
                </pre>
            </div>

        </div>
        <div class="col-12 col-lg-6 col-sm-12 col-md-12">
            <p>Preview Soal : </p>
            <iframe src="{{ asset('storage/pdf/Soal-Tes-Online-Programmer-JMC -IT-Consultant.pdf') }}"
                class="soal p-2"></iframe>
        </div>
    </div>
@endsection
