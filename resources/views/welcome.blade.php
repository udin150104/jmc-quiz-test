<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container-fluid">

        <div class="row">

            <div class="col-12 col-lg-12 col-sm-12 col-md-12">

                <div class="mt-2 p-5 bg-dark text-white rounded-0">
                    <ul class="">
                        <li>Nama : <b>Syahrudin Simanjuntak</b></li>
                        <li>Email : udin150104@gmail.com</li>
                        <li>Telp : +62 882 16189977</li>
                        <li>Website : https://udin150104.github.io</li>
                    </ul>
                </div>

            </div>
            <div class="col-12 col-lg-6 col-sm-12 col-md-12">

                <div class="mt-2 p-5 bg-dark text-white rounded-0">
                    <p class="display-5 "> Test Kemampuan Dasar I </p>
                    {{-- <strong>Level Unknown</strong> --}}
                    <hr>

                    <p class="mt-4">
                        Berikut Jawaban dari soal yang diberikan :
                        <a href="{{ route('app.home') }}" title="Jawaban" class="text-white">Jawaban</a>
                    </p>
                </div>

            </div>
            <div class="col-12 col-lg-6 col-sm-12 col-md-12">
                <div class="mt-2 p-5 bg-dark text-white rounded-0">
                    <p class="display-5 "> Test Kemampuan Dasar II </p>
                    {{-- <strong>Level Medium</strong> --}}
                    <hr>

                    <p class="mt-4">
                        Berikut Jawaban dari soal yang diberikan :
                        <a href="{{ route('app.intro') }}" title="Jawaban" class="text-white">Jawaban</a>
                    </p>
                </div>
            </div>
        </div>

    </div>


</body>

</html>
