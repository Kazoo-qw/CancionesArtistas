<?php

namespace Database\Factories;

use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Única columna NOT NULL sin valor por defecto: album, duration_in_seconds,
            // release_date, genre, status y registered_by son anulables o ya traen default.
            'title' => $this->faker->unique()->words(3, true),
        ];
    }
}
