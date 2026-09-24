<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('songs_artists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('song_id')->constrained()->onDelete('cascade');
            $table->string('producer')->nullable();
            $table->timestamps();

            // Evita que el mismo artista quede asociado dos veces a la misma canción
            $table->unique(['artist_id', 'song_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('songs_artists');
    }
};