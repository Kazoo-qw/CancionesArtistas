@extends('layouts.app')

@section('title', 'Nuevo artista')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('artists.index') }}">Artistas</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registrar artista</h3>
        </div>

        <form action="{{ route('artists.store') }}" method="POST">
            <div class="card-body">
                @include('artists.form')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Guardar
                </button>
                <a href="{{ route('artists.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
