@extends('layouts.app_authentication')

@section('title','Restablecer Contraseña')

@section('content')
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <img src="{{asset('backend/dist/img/logo_audysoft.png')}}" alt="">
        </div>
        <div class="card-body">
            <form action="{{ route('password.request') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group has-feedback">
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group has-feedback">
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" required autocomplete="current-password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group has-feedback">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Contraseña" required autocomplete="new-password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>		
</div>
@endsection
