<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistRequest extends FormRequest
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
                'name' => 'required|string|max:255',
                'genre' => 'nullable|string|max:100',
                'bio' => 'nullable|string',
                'country' => 'nullable|string|max:100',
                'image_path' => 'nullable|string|max:255',
            ];
        }

        // En edición (PUT/PATCH) se validan los mismos campos: ninguna columna de
        // artists es única, así que aquí no hace falta un ->ignore().
        return [
            'name' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'image_path' => 'nullable|string|max:255',
        ];
    }
}
