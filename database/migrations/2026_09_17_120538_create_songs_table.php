<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('album')->nullable();
            $table->unsignedInteger('duration_in_seconds')->nullable();
            $table->date('release_date')->nullable();
            $table->string('genre')->nullable();
            $table->boolean('status')->default(true); // Estado de la canción
            $table->foreignId('registered_by')->nullable()->constrained('users')->onDelete('cascade'); // Usuario que la registró
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
