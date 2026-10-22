@extends('layouts.app')

@section('title', 'Canciones')

@section('breadcrumb')
    <li class="breadcrumb-item active">Canciones</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de canciones</h3>
            <div class="card-tools">
                <a href="{{ route('songs.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Nueva canción
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            @if ($canciones->isEmpty())
                <p class="p-3 mb-0 text-muted">Aún no hay canciones registradas.</p>
            @else
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Álbum</th>
                            <th>Género</th>
                            <th>Lanzamiento</th>
                            <th>Artistas</th>
                            <th>Estado</th>
                            <th class="text-center" style="width: 160px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($canciones as $cancion)
                            <tr>
                                <td>{{ $cancion->id }}</td>
                                <td>{{ $cancion->title }}</td>
                                <td>{{ $cancion->album ?? '—' }}</td>
                                <td>{{ $cancion->genre ?? '—' }}</td>
                                <td>{{ $cancion->release_date ? $cancion->release_date->format('d/m/Y') : '—' }}</td>
                                <td>
                                    @forelse ($cancion->artists as $artista)
                                        <span class="badge badge-info">{{ $artista->name }}</span>
                                    @empty
                                        <span class="text-muted">Sin artistas</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if ($cancion->status)
                                        <span class="badge badge-success">Activa</span>
                                    @else
                                        <span class="badge badge-secondary">Inactiva</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('songs.show', $cancion) }}" class="btn btn-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('songs.edit', $cancion) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('songs.destroy', $cancion) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Seguro que quieres eliminar esta canción?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="card-footer">
            {{ $canciones->links() }}
        </div>
    </div>
@endsection
