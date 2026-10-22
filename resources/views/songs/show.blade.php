@extends('layouts.app')

@section('title', $song->title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('songs.index') }}">Canciones</a></li>
    <li class="breadcrumb-item active">{{ $song->title }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $song->title }}</h3>
            <div class="card-tools">
                <a href="{{ route('songs.edit', $song) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr>
                        <th style="width: 220px">Título</th>
                        <td>{{ $song->title }}</td>
                    </tr>
                    <tr>
                        <th>Álbum</th>
                        <td>{{ $song->album ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Género</th>
                        <td>{{ $song->genre ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Duración (segundos)</th>
                        <td>{{ $song->duration_in_seconds ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de lanzamiento</th>
                        <td>{{ $song->release_date ? $song->release_date->format('d/m/Y') : '—' }}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            @if ($song->status)
                                <span class="badge badge-success">Activa</span>
                            @else
                                <span class="badge badge-secondary">Inactiva</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Artistas</th>
                        <td>
                            @forelse ($song->artists as $artista)
                                <span class="badge badge-info mr-1">
                                    <a href="{{ route('artists.show', $artista) }}" class="text-white">
                                        {{ $artista->name }}
                                    </a>
                                </span>
                            @empty
                                <span class="text-muted">Sin artistas asociados</span>
                            @endforelse
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <a href="{{ route('songs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
        </div>
    </div>
@endsection
