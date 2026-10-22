@extends('layouts.app')

@section('title', 'Editar artista')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('artists.index') }}">Artistas</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar «{{ $artist->name }}»</h3>
        </div>

        {{-- @method('PUT') simula la petición PUT que exige el resource --}}
        <form action="{{ route('artists.update', $artist) }}" method="POST">
            @method('PUT')
            <div class="card-body">
                @include('artists.form')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save mr-1"></i> Actualizar
                </button>
                <a href="{{ route('artists.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
