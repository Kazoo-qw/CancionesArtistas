@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalCanciones }}</h3>
                    <p>Songs registered</p>
                </div>
                <div class="icon">
                    <i class="fas fa-music"></i>
                </div>
                <a href="{{ route('songs.index') }}" class="small-box-footer">
                    View songs <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalArtistas }}</h3>
                    <p>Artists registered</p>
                </div>
                <div class="icon">
                    <i class="fas fa-microphone-alt"></i>
                </div>
                <a href="{{ route('artists.index') }}" class="small-box-footer">
                    View artists <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalAsociaciones }}</h3>
                    <p>Song–artist links</p>
                </div>
                <div class="icon">
                    <i class="fas fa-link"></i>
                </div>
                <a href="{{ route('songs.index') }}" class="small-box-footer">
                    View in songs <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
