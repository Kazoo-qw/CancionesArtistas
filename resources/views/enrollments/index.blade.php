@extends('layouts.app')

@section('title', 'Enrollments')

@section('breadcrumb')
    <li class="breadcrumb-item active">Enrollments</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Songs linked to each artist</h3>
            <div class="card-tools">
                <a href="{{ route('enrollments.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> New enrollment
                </a>
            </div>
        </div>

        <div class="card-body">
            @if ($artistas->isEmpty())
                <p class="mb-0 text-muted">No artists registered yet.</p>
            @else
                <div class="row">
                    {{-- Una tarjeta por artista con sus canciones --}}
                    @foreach ($artistas as $artista)
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-microphone-alt mr-1"></i> {{ $artista->name }}
                                    </h3>
                                    <div class="card-tools">
                                        <span class="badge badge-info">{{ $artista->songArtists->count() }} songs</span>
                                    </div>
                                </div>

                                <ul class="list-group list-group-flush">
                                    @forelse ($artista->songArtists as $vinculo)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $vinculo->song?->title ?? '—' }}</span>

                                            {{-- Quita solo la fila de songs_artists --}}
                                            <form action="{{ route('enrollments.destroy', $vinculo) }}" method="POST"
                                                  onsubmit="return confirm('Remove this song from the artist?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Remove">
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            </form>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted">No songs yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
