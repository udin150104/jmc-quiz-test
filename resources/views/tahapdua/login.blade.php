@extends('layoutlogin')

@section('title', 'Beranda')

@php
    $page = 'auth';
@endphp


@section('content')
    <div class="row min-vh-100 p-0 m-0">
        <!-- Kiri: Form Login -->
        <div class="col-md-4 d-flex align-items-center justify-content-center bg-light">
            <div class="w-100 p-4">
                <h2 class=" display-3 mb-4"> <i class="bi bi-shield-lock me-1"></i> Akses Masuk</h2>
                <hr>
                <p class="text-muted mb-4">Selamat Datang, Silahkan masukkan username dan password anda.</p>

                <form method="POST" action="{{route('app.login.process')}}">
                    @csrf

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">Inisial Akses</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            placeholder="Masukkan username" id="username" name="username" value="{{ old('username') }}"
                            required autofocus>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password" id="password" name="password" required>
                            <span class="input-group-text bg-transparent">
                                <i class="bi bi-eye-slash pointer" id="togglePassword"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-dark text-uppercase mb-3">
                            <i class="bi bi-box-arrow-in-right me-1 fs-5"></i> Masuk
                        </button>
                        <a href="{{ route('app.intro') }}" class="btn btn-link text-uppercase mb-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="button" class="btn  text-uppercase mb-3" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
                            <i class="bi bi-lightbulb me-1 text-warning fs-5"></i> Hint
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kanan: Gambar -->
        <div class="col-md-8 p-0 d-none d-md-block">
            <img src="{{ asset('images/login-image.jpg') }}" alt="Login Image"
                class="img-fluid h-100 w-100 object-fit-cover">
        </div>
    </div>


    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasTopLabel"><i class="bi bi-lightbulb me-1 text-warning fs-5"></i> Hint</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            
          <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
              <strong>Administator Sample Data</strong> <br>

              <table class="table table-bordered mt-2">
                <tbody>
                  <tr>
                    <td width="200">Username</td>
                    <td >administator</td>
                  </tr>
                  <tr>
                    <td>Password</td>
                    <td>Adm1n*48*123</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
              <strong>Operator Sample Data</strong> <br>

              <table class="table table-bordered mt-2">
                <tbody>
                  <tr>
                    <td width="200">Username</td>
                    <td>operator</td>
                  </tr>
                  <tr>
                    <td>Password</td>
                    <td>Oper4t*rrr</td>
                  </tr>
                </tbody>
              </table>             

            </div>
          </div>
          
        </div>
    </div>
@endsection
