@extends('layouts.app')

@section('title', 'Songs')

@section('breadcrumb')
    <li class="breadcrumb-item active">Songs</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Song list</h3>
            <div class="card-tools">
                <a href="{{ route('songs.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> New song
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            @if ($canciones->isEmpty())
                <p class="p-3 mb-0 text-muted">No songs registered yet.</p>
            @else
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Album</th>
                            <th>Genre</th>
                            <th>Released</th>
                            <th>Artists</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 160px">Actions</th>
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
                                        <span class="text-muted">No artists</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if ($cancion->status)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('songs.show', $cancion) }}" class="btn btn-info btn-sm" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('songs.edit', $cancion) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('songs.destroy', $cancion) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this song?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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
    </div>
@endsection
