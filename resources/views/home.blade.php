@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    
                    <div class="mt-4">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div> <!-- Cierre de card-body -->
            </div> <!-- Cierre de card -->
        </div> <!-- Cierre de col-md-8 -->
    </div> <!-- Cierre de row -->
</div> <!-- Cierre de container -->
@endsection <!-- Cierre de la sección content -->