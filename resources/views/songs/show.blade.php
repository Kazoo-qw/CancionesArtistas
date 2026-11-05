@extends('layouts.app')

@section('title', $song->title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('songs.index') }}">Songs</a></li>
    <li class="breadcrumb-item active">{{ $song->title }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $song->title }}</h3>
            <div class="card-tools">
                <a href="{{ route('songs.edit', $song) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr>
                        <th style="width: 220px">Title</th>
                        <td>{{ $song->title }}</td>
                    </tr>
                    <tr>
                        <th>Album</th>
                        <td>{{ $song->album ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Genre</th>
                        <td>{{ $song->genre ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Duration (seconds)</th>
                        <td>{{ $song->duration_in_seconds ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Release date</th>
                        <td>{{ $song->release_date ? $song->release_date->format('d/m/Y') : '—' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($song->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Artists</th>
                        <td>
                            @forelse ($song->artists as $artista)
                                <span class="badge badge-info mr-1">
                                    <a href="{{ route('artists.show', $artista) }}" class="text-white">
                                        {{ $artista->name }}
                                    </a>
                                </span>
                            @empty
                                <span class="text-muted">No artists assigned</span>
                            @endforelse
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <a href="{{ route('songs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>
@endsection
