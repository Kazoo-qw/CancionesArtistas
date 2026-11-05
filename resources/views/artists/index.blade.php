@extends('layouts.app')

@section('title', 'Artists')

@section('breadcrumb')
    <li class="breadcrumb-item active">Artists</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Artist list</h3>
            <div class="card-tools">
                <a href="{{ route('artists.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> New artist
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            @if ($artistas->isEmpty())
                <p class="p-3 mb-0 text-muted">No artists registered yet.</p>
            @else
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Genre</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 160px">Actions</th>
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
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('artists.show', $artista) }}" class="btn btn-info btn-sm" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('artists.edit', $artista) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('artists.destroy', $artista) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this artist?');">
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
