<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongRequest;
use App\Models\Artist;
use App\Models\Song;

class SongController extends Controller
{
    // GET /songs — listado paginado con sus artistas.
    public function index()
    {
        // DataTables pagina y busca en el navegador, así que traemos todo el listado.
        $canciones = Song::with('artists')->orderBy('title')->get();

        return view('songs.index', compact('canciones'));
    }

    // GET /songs/create — formulario vacío.
    public function create()
    {
        $artistas = Artist::orderBy('name')->get();

        return view('songs.create', compact('artistas'));
    }

    // POST /songs — guarda la canción y sus artistas.
    public function store(SongRequest $request)
    {
        $datos = $request->validated();

        // artist_ids no es una columna de songs, se usa solo para el pivote.
        $artistasSeleccionados = $datos['artist_ids'] ?? [];
        unset($datos['artist_ids']);

        $datos['status'] = $request->boolean('status');
        $datos['registered_by'] = auth()->id();

        $cancion = Song::create($datos);
        $cancion->artists()->sync($artistasSeleccionados);

        return redirect()
            ->route('songs.index')
            ->with('exito', 'Song created successfully.');
    }

    // GET /songs/{song} — detalle de la canción.
    // Forma del material: se recibe el id y se busca con findOrFail (404 si no existe).
    public function show($id)
    {
        $song = Song::with(['artists'])->findOrFail($id);

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
    public function update(SongRequest $request, Song $song)
    {
        $datos = $request->validated();

        $artistasSeleccionados = $datos['artist_ids'] ?? [];
        unset($datos['artist_ids']);

        $datos['status'] = $request->boolean('status');

        $song->update($datos);
        $song->artists()->sync($artistasSeleccionados);

        return redirect()
            ->route('songs.index')
            ->with('exito', 'Song updated successfully.');
    }

    // DELETE /songs/{song} — borra la canción.
    public function destroy(Song $song)
    {
        // songs_artists tiene llave foránea hacia songs: hay que desvincular antes.
        $song->artists()->detach();
        $song->delete();

        return redirect()
            ->route('songs.index')
            ->with('exito', 'Song deleted successfully.');
    }
}
