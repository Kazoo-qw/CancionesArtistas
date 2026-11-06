@extends('layouts.app_authentication')

@section('title','Reset Password')

@section('content')
<div class="login-box">
    <div class="card card-outline card-primary">
        {{-- El logo de la plantilla todavía no está en public/: se quita el <img> para no mostrar el icono roto --}}
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group has-feedback">
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>		
</div>
@endsection
