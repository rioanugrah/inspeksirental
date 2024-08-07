@extends('layouts.auth.master')
@section('title')
    Login
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-lg-6 p-4">
                        <div class="mx-auto">
                            <a href="{{ route('login') }}">
                                <img src="assets/images/logo-dark.png" alt="" height="24" />
                            </a>
                        </div>
                        <center>
                            <h6 class="h5 mb-0 mt-3">Selamat Datang Di <br> <b>AFKAR MAHESA MOBIL</b></h6>
                            <p class="text-muted mt-1 mb-4">
                                Login Untuk Memulai Aktifitasmu
                            </p>
                        </center>
                        

                        <form action="{{ route('login') }}" method="POST" class="authentication-form">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="icon-dual" data-feather="mail"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <a href="{{ route('password.request') }}" class="float-end text-muted text-unline-dashed ms-1">Lupa password?</a>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="icon-dual" data-feather="lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>

                            <div class="mb-3 text-center d-grid">
                                <button class="btn btn-primary" type="submit">Log In</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 d-none d-md-inline-block">
                        <div class="auth-page-sidebar" style="background-image: url({{ asset('backend/assets/images/covers/bg.jpg') }})">
                            <div class="overlay"></div>
                            <div class="auth-user-testimonial">
                                <p class="fs-24 fw-bold text-white mb-1">AFKAR MAHESA MOBIL</p>
                                <p class="lead">"Solusi Inspeksi Mobil Bekas Malang !"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <p class="text-muted">Copyright 2024 &copy;Codein Solution</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
