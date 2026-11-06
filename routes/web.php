<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

// La portada manda al panel: todo el sitio requiere sesión iniciada.
Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('welcome');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('songs', SongController::class);
    Route::resource('artists', ArtistController::class);

    // Inscripciones: el par canción–artista de la tabla intermedia songs_artists.
    // No tienen controlador propio: las atiende ArtistController.
    Route::get('enrollments', [ArtistController::class, 'enrollments'])->name('enrollments.index');
    Route::get('enrollments/create', [ArtistController::class, 'createEnrollment'])->name('enrollments.create');
    Route::post('enrollments', [ArtistController::class, 'storeEnrollment'])->name('enrollments.store');
    Route::delete('enrollments/{enrollment}', [ArtistController::class, 'destroyEnrollment'])->name('enrollments.destroy');
});
