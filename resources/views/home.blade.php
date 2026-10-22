@extends('layouts.app')

@section('title', 'Panel de control')

@section('breadcrumb')
    <li class="breadcrumb-item active">Panel de control</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalCanciones }}</h3>
                    <p>Canciones registradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-music"></i>
                </div>
                <a href="{{ route('songs.index') }}" class="small-box-footer">
                    Ver canciones <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalArtistas }}</h3>
                    <p>Artistas registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-microphone-alt"></i>
                </div>
                <a href="{{ route('artists.index') }}" class="small-box-footer">
                    Ver artistas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalAsociaciones }}</h3>
                    <p>Asociaciones canción–artista</p>
                </div>
                <div class="icon">
                    <i class="fas fa-link"></i>
                </div>
                <a href="{{ route('songs.index') }}" class="small-box-footer">
                    Ver en las canciones <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
