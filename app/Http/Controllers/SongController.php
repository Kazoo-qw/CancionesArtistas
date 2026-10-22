<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    // GET /songs — listado paginado con sus artistas.
    public function index()
    {
        $canciones = Song::with('artists')->orderBy('title')->paginate(10);

        return view('songs.index', compact('canciones'));
    }

    // GET /songs/create — formulario vacío.
    public function create()
    {
        $artistas = Artist::orderBy('name')->get();

        return view('songs.create', compact('artistas'));
    }

    // POST /songs — guarda la canción y sus artistas.
    public function store(Request $request)
    {
        $datos = $this->validar($request);

        // artist_ids no es una columna de songs, se usa solo para el pivote.
        $artistasSeleccionados = $datos['artist_ids'] ?? [];
        unset($datos['artist_ids']);

        $datos['status'] = $request->boolean('status');
        $datos['registered_by'] = auth()->id();

        $cancion = Song::create($datos);
        $cancion->artists()->sync($artistasSeleccionados);

        return redirect()
            ->route('songs.index')
            ->with('exito', 'La canción se registró correctamente.');
    }

    // GET /songs/{song} — detalle de la canción.
    public function show(Song $song)
    {
        $song->load('artists');

        return view('songs.show', compact('song'));
    }

    // GET /songs/{song}/edit — formulario con los artistas ya marcados.
    public function edit(Song $song)
    {
        $artistas = Artist::orderBy('name')->get();
        $seleccionados = $song->artists->pluck('id')->all();

        return view('songs.edit', compact('song', 'artistas', 'seleccionados'));
    }

    // PUT/PATCH /songs/{song} — actualiza canción y artistas.
    public function update(Request $request, Song $song)
    {
        $datos = $this->validar($request);

        $artistasSeleccionados = $datos['artist_ids'] ?? [];
        unset($datos['artist_ids']);

        $datos['status'] = $request->boolean('status');

        $song->update($datos);
        $song->artists()->sync($artistasSeleccionados);

        return redirect()
            ->route('songs.index')
            ->with('exito', 'La canción se actualizó correctamente.');
    }

    // DELETE /songs/{song} — borra la canción.
    public function destroy(Song $song)
    {
        // songs_artists tiene llave foránea hacia songs: hay que desvincular antes.
        $song->artists()->detach();
        $song->delete();

        return redirect()
            ->route('songs.index')
            ->with('exito', 'La canción se eliminó correctamente.');
    }

    // Reglas que comparten store() y update().
    private function validar(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'album' => ['nullable', 'string', 'max:255'],
            'duration_in_seconds' => ['nullable', 'integer', 'min:0'],
            'release_date' => ['nullable', 'date'],
            'genre' => ['nullable', 'string', 'max:100'],
            'artist_ids' => ['nullable', 'array'],
            'artist_ids.*' => ['exists:artists,id'],
        ]);
    }
}
