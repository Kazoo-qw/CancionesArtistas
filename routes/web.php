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
});
