<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Única columna NOT NULL sin valor por defecto: genre, bio, country,
            // image_path, status y registered_by son anulables o ya traen default.
            'name' => $this->faker->unique()->name(),
        ];
    }
}
