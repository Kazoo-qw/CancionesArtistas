@extends('layouts.app')

@section('title', $song->title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('songs.index') }}">Songs</a></li>
    <li class="breadcrumb-item active">{{ $song->title }}</li>
@endsection

@section('content')
    {{-- Ojo: layouts.app ya pone el content-wrapper, el H1 y el breadcrumb,
         así que aquí NO se repiten; si no, quedaría un wrapper dentro de otro. --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h3 class="card-title">Song details</h3>
                    <div class="card-tools">
                        <a href="{{ route('songs.edit', $song) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Title</label>
                                <p>{{ $song->title }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Album</label>
                                <p>{{ $song->album ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Genre</label>
                                <p>{{ $song->genre ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Duration (seconds)</label>
                                <p>{{ $song->duration_in_seconds ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Release date</label>
                                <p>{{ $song->release_date ? $song->release_date->format('d/m/Y') : '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Status</label>
                                <p>
                                    @if ($song->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-8 col-12">
                            <div class="form-group">
                                <label>Artists</label>
                                <p>
                                    @forelse ($song->artists as $artista)
                                        <span class="badge badge-info mr-1">
                                            <a href="{{ route('artists.show', $artista) }}" class="text-white">
                                                {{ $artista->name }}
                                            </a>
                                        </span>
                                    @empty
                                        <span class="text-muted">No artists assigned</span>
                                    @endforelse
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-2 col-4">
                            <a href="{{ route('songs.index') }}" class="btn btn-danger btn-block btn-flat">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
