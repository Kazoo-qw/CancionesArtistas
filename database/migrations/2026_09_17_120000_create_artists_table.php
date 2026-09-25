<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('genre')->nullable();
            $table->text('bio')->nullable();
            $table->string('country')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('status')->default(true); // Estado del artista (true = activo, false = inactivo)
            $table->foreignId('registered_by')->nullable(); // Usuario que lo registró
            $table->timestamps();

            $table->index('name'); // Acelera búsquedas y filtros por nombre de artista
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};