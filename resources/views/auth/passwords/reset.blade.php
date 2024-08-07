{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
@extends('layouts.auth.master')
@section('title')
    New Password Account
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-lg-6 p-4">
                        <div class="mx-auto">
                            <a href="index.html">
                                <img src="assets/images/logo-dark.png" alt="" height="24" />
                            </a>
                        </div>

                        <h6 class="h5 mb-0 mt-3">Reset Password</h6>
                        <p class="text-muted mt-1 mb-4">Enter your email address and we'll send you an email with instructions to reset your password.</p>

                        <form method="POST" action="{{ route('password.update') }}" class="authentication-form">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                       <i class="icon-dual" data-feather="mail"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $email ?? old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                       <i class="icon-dual" data-feather="key"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="email" placeholder="Password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                       <i class="icon-dual" data-feather="key"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" id="email" placeholder="Confirm Password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-0 text-center">
                                <button class="btn btn-primary w-100" type="submit"> Reset Password</button>
                            </div>
                        </form>
                        
                    </div>
                    <div class="col-lg-6 d-none d-lg-inline-block">
                        <div class="auth-page-sidebar" style="background-image: url({{ asset('backend/assets/images/covers/bg.jpg') }})">
                            <div class="overlay"></div>
                            <div class="auth-user-testimonial">
                                <p class="fs-24 fw-bold text-white mb-1">INSPEKSI MOBIL</p>
                                <p class="lead">"Permudah Pekerjaanmu Dengan Satu Aplikasi !"</p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div> <!-- end card-body -->
        </div>
        <!-- end card -->

        <div class="row mt-3">
            <div class="col-12 text-center">
                <p class="text-muted">Back to <a href="{{ route('login') }}" class="text-primary fw-bold ms-1">Login</a></p>
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- end col -->
</div>
@endsection