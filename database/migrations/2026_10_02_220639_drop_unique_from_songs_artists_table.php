<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Quita el UNIQUE de la tabla pivote.
     *
     * El profesor pidió que SongArtistFactory sea únicamente:
     *     'song_id'   => Song::inRandomOrder()->first()->id,
     *     'artist_id' => Artist::inRandomOrder()->first()->id,
     * y que corra con SongArtist::factory(200)->create();.
     *
     * Ese fragmento elige al azar CON repetición (medido el 2026-10-02: sobre los
     * 400 pares posibles, 200 intentos dan 152-162 distintos), así que con el
     * UNIQUE de la tabla revienta con UniqueConstraintViolationException antes de
     * llegar a 200 (promedio en el registro 23). El estudiante confirmó que el
     * UNIQUE no lo pidió el profesor, así que se elimina.
     *
     * Consecuencia: la tabla ya no impide que un mismo artista aparezca dos veces
     * asociado a la misma canción. Si hace falta volver a esa regla, esta
     * migración es reversible con `php artisan migrate:rollback` (o basta volver
     * a crear el índice).
     */
    public function up(): void
    {
        Schema::table('songs_artists', function (Blueprint $table) {
            $table->dropUnique(['artist_id', 'song_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs_artists', function (Blueprint $table) {
            $table->unique(['artist_id', 'song_id']);
        });
    }
};
