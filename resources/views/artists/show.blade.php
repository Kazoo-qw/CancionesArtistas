@extends('layouts.app')

@section('title', $artist->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('artists.index') }}">Artistas</a></li>
    <li class="breadcrumb-item active">{{ $artist->name }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $artist->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('artists.edit', $artist) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr>
                        <th style="width: 220px">Nombre</th>
                        <td>{{ $artist->name }}</td>
                    </tr>
                    <tr>
                        <th>Género</th>
                        <td>{{ $artist->genre ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>País</th>
                        <td>{{ $artist->country ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Biografía</th>
                        <td>{{ $artist->bio ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Imagen</th>
                        <td>{{ $artist->image_path ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            @if ($artist->status)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-secondary">Inactivo</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Canciones</th>
                        <td>
                            @forelse ($artist->songs as $cancion)
                                <span class="badge badge-info mr-1">
                                    <a href="{{ route('songs.show', $cancion) }}" class="text-white">
                                        {{ $cancion->title }}
                                    </a>
                                </span>
                            @empty
                                <span class="text-muted">Sin canciones asociadas</span>
                            @endforelse
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <a href="{{ route('artists.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
        </div>
    </div>
@endsection
