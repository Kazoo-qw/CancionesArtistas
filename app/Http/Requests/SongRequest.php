<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongRequest extends FormRequest
{
    // La ruta ya está detrás del middleware 'auth', así que aquí siempre se permite.
    public function authorize(): bool
    {
        return true;
    }

    // Forma del material de clase: se pregunta por el método HTTP.
    public function rules(): array
    {
        if (request()->isMethod('post')) {
            return [
                'title' => 'required|string|max:255',
                'album' => 'nullable|string|max:255',
                'duration_in_seconds' => 'nullable|integer|min:0',
                'release_date' => 'nullable|date',
                'genre' => 'nullable|string|max:100',
                // artist_ids no es una columna de songs, se usa solo para el pivote.
                'artist_ids' => 'nullable|array',
                'artist_ids.*' => 'exists:artists,id',
            ];
        }

        // En edición (PUT/PATCH) se validan los mismos campos: ninguna columna de
        // songs es única, así que aquí no hace falta un ->ignore().
        return [
            'title' => 'required|string|max:255',
            'album' => 'nullable|string|max:255',
            'duration_in_seconds' => 'nullable|integer|min:0',
            'release_date' => 'nullable|date',
            'genre' => 'nullable|string|max:100',
            'artist_ids' => 'nullable|array',
            'artist_ids.*' => 'exists:artists,id',
        ];
    }
}
