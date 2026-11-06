@extends('layouts.app')

@section('title', 'New enrollment')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('enrollments.index') }}">Enrollments</a></li>
    <li class="breadcrumb-item active">New enrollment</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Link a song to an artist</h3>
        </div>

        <form action="{{ route('enrollments.store') }}" method="POST">
            @csrf

            <div class="card-body">
                <p class="text-muted">
                    Pick one song and one artist. The pair is saved in the songs_artists table.
                </p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="song_id">Song *</label>
                            <select name="song_id" id="song_id"
                                    class="form-control @error('song_id') is-invalid @enderror">
                                <option value="">Choose a song…</option>
                                @foreach ($canciones as $cancion)
                                    <option value="{{ $cancion->id }}"
                                        {{ old('song_id') == $cancion->id ? 'selected' : '' }}>
                                        {{ $cancion->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('song_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="artist_id">Artist *</label>
                            <select name="artist_id" id="artist_id"
                                    class="form-control @error('artist_id') is-invalid @enderror">
                                <option value="">Choose an artist…</option>
                                @foreach ($artistas as $artista)
                                    <option value="{{ $artista->id }}"
                                        {{ old('artist_id') == $artista->id ? 'selected' : '' }}>
                                        {{ $artista->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('artist_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save enrollment
                </button>
                <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
