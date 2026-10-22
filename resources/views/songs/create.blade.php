@extends('layouts.app')

@section('title', 'Nueva canción')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('songs.index') }}">Canciones</a></li>
    <li class="breadcrumb-item active">Nueva</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registrar canción</h3>
        </div>

        <form action="{{ route('songs.store') }}" method="POST">
            <div class="card-body">
                @include('songs.form', ['seleccionados' => []])
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Guardar
                </button>
                <a href="{{ route('songs.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
