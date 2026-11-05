@extends('layouts.app')

@section('title', 'New song')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('songs.index') }}">Songs</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Register song</h3>
        </div>

        <form action="{{ route('songs.store') }}" method="POST">
            <div class="card-body">
                @include('songs.form', ['seleccionados' => []])
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save
                </button>
                <a href="{{ route('songs.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
