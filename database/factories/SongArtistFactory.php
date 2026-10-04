<?php

namespace Database\Factories;

use App\Models\Artist;
use App\Models\Song;
use App\Models\SongArtist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SongArtist>
 */
class SongArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * Forma que pidió el profesor, literal. `producer` es anulable → se omite.
     *
     * Requiere que `songs` y `artists` ya tengan registros: en `DatabaseSeeder`
     * se crean antes que esta tabla.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'song_id' => Song::inRandomOrder()->first()->id,
            'artist_id' => Artist::inRandomOrder()->first()->id,
        ];
    }
}
