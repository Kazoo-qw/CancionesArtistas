<?php

use App\Models\Artist;
use App\Models\Song;
use App\Models\SongArtist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // El módulo está detrás del middleware 'auth', igual que el resto del panel.
    $this->actingAs(User::factory()->create());
});

test('las rutas de inscripciones piden sesión iniciada', function () {
    auth()->logout();

    $this->get(route('enrollments.index'))->assertRedirect(route('login'));
    $this->get(route('enrollments.create'))->assertRedirect(route('login'));
});

test('el listado y el formulario de inscripciones cargan', function () {
    $cancion = Song::factory()->create();
    $artista = Artist::factory()->create(['name' => 'Artista con canción']);
    $cancion->artists()->attach($artista);

    $this->get(route('enrollments.index'))->assertOk()->assertSee('Enrollments');
    $this->get(route('enrollments.create'))->assertOk()->assertSee('New enrollment');
});

test('una inscripción crea la fila en songs_artists', function () {
    $cancion = Song::factory()->create();
    $artista = Artist::factory()->create();

    $this->post(route('enrollments.store'), [
        'song_id' => $cancion->id,
        'artist_id' => $artista->id,
    ])->assertRedirect(route('enrollments.index'))
        ->assertSessionHas('exito');

    expect(SongArtist::where('song_id', $cancion->id)
        ->where('artist_id', $artista->id)
        ->count())->toBe(1);
});

test('no se repite el mismo par canción-artista', function () {
    $cancion = Song::factory()->create();
    $artista = Artist::factory()->create();
    $cancion->artists()->attach($artista);

    $this->post(route('enrollments.store'), [
        'song_id' => $cancion->id,
        'artist_id' => $artista->id,
    ])->assertRedirect(route('enrollments.index'))
        ->assertSessionHas('error');

    expect(SongArtist::count())->toBe(1);
});

test('quitar una inscripción borra solo la fila intermedia', function () {
    $cancion = Song::factory()->create();
    $artista = Artist::factory()->create();
    $cancion->artists()->attach($artista);

    $vinculo = SongArtist::firstOrFail();

    $this->delete(route('enrollments.destroy', $vinculo))
        ->assertRedirect(route('enrollments.index'))
        ->assertSessionHas('exito');

    expect(SongArtist::count())->toBe(0);
    expect(Song::find($cancion->id))->not->toBeNull();
    expect(Artist::find($artista->id))->not->toBeNull();
});

test('la validación exige canción y artista existentes', function () {
    $this->from(route('enrollments.create'))
        ->post(route('enrollments.store'), ['song_id' => 999, 'artist_id' => 999])
        ->assertRedirect(route('enrollments.create'))
        ->assertSessionHasErrors(['song_id', 'artist_id']);
});
