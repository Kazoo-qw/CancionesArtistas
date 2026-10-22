@extends('layouts.app')

@section('title', 'Artistas')

@section('breadcrumb')
    <li class="breadcrumb-item active">Artistas</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de artistas</h3>
            <div class="card-tools">
                <a href="{{ route('artists.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Nuevo artista
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            @if ($artistas->isEmpty())
                <p class="p-3 mb-0 text-muted">Aún no hay artistas registrados.</p>
            @else
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Género</th>
                            <th>País</th>
                            <th>Estado</th>
                            <th class="text-center" style="width: 160px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($artistas as $artista)
                            <tr>
                                <td>{{ $artista->id }}</td>
                                <td>{{ $artista->name }}</td>
                                <td>{{ $artista->genre ?? '—' }}</td>
                                <td>{{ $artista->country ?? '—' }}</td>
                                <td>
                                    @if ($artista->status)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('artists.show', $artista) }}" class="btn btn-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('artists.edit', $artista) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('artists.destroy', $artista) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Seguro que quieres eliminar este artista?');">
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
            {{ $artistas->links() }}
        </div>
    </div>
@endsection
