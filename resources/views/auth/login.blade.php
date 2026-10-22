@extends('layouts.app_authentication')

@section('title', 'Login')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('backend/dist/img/logo_audysoft.png') }}" alt="">
            </div>
            <div class="card-body">
                <p class="login-box-msg">{{ __('Log In') }}</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Correo">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password" placeholder="Contraseña">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-1">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
