<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArtistRequest;
use App\Models\Artist;
use App\Models\Song;
use App\Models\SongArtist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    // GET /artists — listado paginado.
    public function index()
    {
        // DataTables pagina y busca en el navegador, así que traemos todo el listado.
        $artistas = Artist::orderBy('name')->get();

        return view('artists.index', compact('artistas'));
    }

    // GET /artists/create — formulario vacío.
    public function create()
    {
        return view('artists.create');
    }

    // POST /artists — guarda el artista.
    public function store(ArtistRequest $request)
    {
        $datos = $request->validated();

        $datos['status'] = $request->boolean('status');
        $datos['registered_by'] = auth()->id();

        Artist::create($datos);

        return redirect()
            ->route('artists.index')
            ->with('exito', 'Artist created successfully.');
    }

    // GET /artists/{artist} — detalle del artista y sus canciones.
    // Forma del material: se recibe el id y se busca con findOrFail (404 si no existe).
    public function show($id)
    {
        $artist = Artist::with(['songs'])->findOrFail($id);

        return view('artists.show', compact('artist'));
    }

    // GET /artists/{artist}/edit — formulario con los datos actuales.
    public function edit(Artist $artist)
    {
        return view('artists.edit', compact('artist'));
    }

    // PUT/PATCH /artists/{artist} — actualiza el artista.
    public function update(ArtistRequest $request, Artist $artist)
    {
        $datos = $request->validated();

        $datos['status'] = $request->boolean('status');

        $artist->update($datos);

        return redirect()
            ->route('artists.index')
            ->with('exito', 'Artist updated successfully.');
    }

    // DELETE /artists/{artist} — borra el artista.
    public function destroy(Artist $artist)
    {
        // songs_artists tiene llave foránea hacia artists: hay que desvincular antes.
        $artist->songs()->detach();
        $artist->delete();

        return redirect()
            ->route('artists.index')
            ->with('exito', 'Artist deleted successfully.');
    }

    // ---------------------------------------------------------------------
    // Tabla intermedia songs_artists (Enrollments).
    // No tiene controlador propio: se maneja desde ArtistController.
    // ---------------------------------------------------------------------

    // GET /enrollments — cada artista con las canciones que tiene asociadas.
    public function enrollments()
    {
        // with('songArtists.song') trae los vínculos y sus canciones de una vez (evita N+1).
        $artistas = Artist::with('songArtists.song')->orderBy('name')->get();

        return view('enrollments.index', compact('artistas'));
    }

    // GET /enrollments/create — formulario para asociar una canción con un artista.
    public function createEnrollment()
    {
        $canciones = Song::orderBy('title')->get();
        $artistas = Artist::orderBy('name')->get();

        return view('enrollments.create', compact('canciones', 'artistas'));
    }

    // POST /enrollments — inserta el par (song_id, artist_id) en songs_artists.
    public function storeEnrollment(Request $request)
    {
        $datos = $this->validarVinculo($request);

        // Desde 2026-10-02 la tabla no tiene UNIQUE, así que el duplicado se evita aquí.
        $existe = SongArtist::where('song_id', $datos['song_id'])
            ->where('artist_id', $datos['artist_id'])
            ->exists();

        if ($existe) {
            return redirect()
                ->route('enrollments.index')
                ->with('error', 'That artist is already linked to that song.');
        }

        SongArtist::create($datos);

        return redirect()
            ->route('enrollments.index')
            ->with('exito', 'Enrollment created successfully.');
    }

    // DELETE /enrollments/{enrollment} — quita el vínculo; no borra la canción ni el artista.
    public function destroyEnrollment(SongArtist $enrollment)
    {
        $enrollment->delete();

        return redirect()
            ->route('enrollments.index')
            ->with('exito', 'Enrollment removed successfully.');
    }

    // Reglas que usa storeEnrollment().
    private function validarVinculo(Request $request): array
    {
        // El tercer argumento pone nombres legibles en los mensajes de error.
        return $request->validate([
            'song_id' => ['required', 'exists:songs,id'],
            'artist_id' => ['required', 'exists:artists,id'],
        ], [], [
            'song_id' => 'song',
            'artist_id' => 'artist',
        ]);
    }
}
