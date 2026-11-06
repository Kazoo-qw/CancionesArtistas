@extends('layouts.app')

@section('title', $artist->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('artists.index') }}">Artists</a></li>
    <li class="breadcrumb-item active">{{ $artist->name }}</li>
@endsection

@section('content')
    {{-- Ojo: layouts.app ya pone el content-wrapper, el H1 y el breadcrumb,
         así que aquí NO se repiten; si no, quedaría un wrapper dentro de otro. --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h3 class="card-title">Artist details</h3>
                    <div class="card-tools">
                        <a href="{{ route('artists.edit', $artist) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <p>{{ $artist->name }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Genre</label>
                                <p>{{ $artist->genre ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Country</label>
                                <p>{{ $artist->country ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Status</label>
                                <p>
                                    @if ($artist->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Image</label>
                                <p>{{ $artist->image_path ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="form-group">
                                <label>Biography</label>
                                <p>{{ $artist->bio ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="form-group">
                                <label>Songs</label>
                                <p>
                                    @forelse ($artist->songs as $cancion)
                                        <span class="badge badge-info mr-1">
                                            <a href="{{ route('songs.show', $cancion) }}" class="text-white">
                                                {{ $cancion->title }}
                                            </a>
                                        </span>
                                    @empty
                                        <span class="text-muted">No songs assigned</span>
                                    @endforelse
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-2 col-4">
                            <a href="{{ route('artists.index') }}" class="btn btn-danger btn-block btn-flat">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
