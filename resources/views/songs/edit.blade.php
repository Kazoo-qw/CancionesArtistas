@extends('layouts.app')

@section('title', 'Editar canción')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('songs.index') }}">Canciones</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar «{{ $song->title }}»</h3>
        </div>

        {{-- @method('PUT') simula la petición PUT que exige el resource --}}
        <form action="{{ route('songs.update', $song) }}" method="POST">
            @method('PUT')
            <div class="card-body">
                @include('songs.form', ['seleccionados' => $song->artists->pluck('id')->all()])
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save mr-1"></i> Actualizar
                </button>
                <a href="{{ route('songs.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
