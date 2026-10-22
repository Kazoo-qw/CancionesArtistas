<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    // GET /artists — listado paginado.
    public function index()
    {
        $artistas = Artist::orderBy('name')->paginate(10);

        return view('artists.index', compact('artistas'));
    }

    // GET /artists/create — formulario vacío.
    public function create()
    {
        return view('artists.create');
    }

    // POST /artists — guarda el artista.
    public function store(Request $request)
    {
        $datos = $this->validar($request);

        $datos['status'] = $request->boolean('status');
        $datos['registered_by'] = auth()->id();

        Artist::create($datos);

        return redirect()
            ->route('artists.index')
            ->with('exito', 'El artista se registró correctamente.');
    }

    // GET /artists/{artist} — detalle del artista y sus canciones.
    public function show(Artist $artist)
    {
        $artist->load('songs');

        return view('artists.show', compact('artist'));
    }

    // GET /artists/{artist}/edit — formulario con los datos actuales.
    public function edit(Artist $artist)
    {
        return view('artists.edit', compact('artist'));
    }

    // PUT/PATCH /artists/{artist} — actualiza el artista.
    public function update(Request $request, Artist $artist)
    {
        $datos = $this->validar($request);

        $datos['status'] = $request->boolean('status');

        $artist->update($datos);

        return redirect()
            ->route('artists.index')
            ->with('exito', 'El artista se actualizó correctamente.');
    }

    // DELETE /artists/{artist} — borra el artista.
    public function destroy(Artist $artist)
    {
        // songs_artists tiene llave foránea hacia artists: hay que desvincular antes.
        $artist->songs()->detach();
        $artist->delete();

        return redirect()
            ->route('artists.index')
            ->with('exito', 'El artista se eliminó correctamente.');
    }

    // Reglas que comparten store() y update().
    private function validar(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'genre' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string'],
            'country' => ['nullable', 'string', 'max:100'],
            'image_path' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
