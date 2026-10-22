<?php

use App\Models\Artist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Todas las rutas del panel están detrás del middleware 'auth'.
    $this->actingAs(User::factory()->create());
});

test('las rutas del panel piden sesión iniciada', function () {
    auth()->logout();

    $this->get(route('songs.index'))->assertRedirect(route('login'));
    $this->get(route('artists.index'))->assertRedirect(route('login'));
});

test('el listado de canciones y el panel de control cargan', function () {
    $this->get(route('songs.index'))->assertOk();
    $this->get(route('artists.index'))->assertOk();
    $this->get(route('home'))->assertOk();
});

test('una canción se registra con sus artistas (relación N:M)', function () {
    $artistas = Artist::factory()->count(2)->create();

    $this->post(route('songs.store'), [
        'title' => 'Canción de prueba',
        'album' => 'Álbum X',
        'duration_in_seconds' => 200,
        'release_date' => '2026-01-15',
        'genre' => 'Rock',
        'status' => '1',
        'artist_ids' => $artistas->pluck('id')->all(),
    ])->assertRedirect(route('songs.index'));

    $cancion = Song::where('title', 'Canción de prueba')->firstOrFail();

    expect($cancion->artists)->toHaveCount(2);
    expect($cancion->registered_by)->toBe(auth()->id());
    expect($cancion->status)->toBeTruthy();
});

test('la validación no deja guardar una canción sin título', function () {
    $this->from(route('songs.create'))
        ->post(route('songs.store'), ['title' => ''])
        ->assertRedirect(route('songs.create'))
        ->assertSessionHasErrors('title');
});

test('editar una canción cambia sus artistas con sync()', function () {
    [$original, $nuevo] = Artist::factory()->count(2)->create();
    $cancion = Song::factory()->create(['title' => 'Original']);
    $cancion->artists()->attach($original);

    $this->put(route('songs.update', $cancion), [
        'title' => 'Editada',
        'status' => '0',
        'artist_ids' => [$nuevo->id],
    ])->assertRedirect(route('songs.index'));

    expect($cancion->fresh()->title)->toBe('Editada');
    expect($cancion->fresh()->status)->toBeFalsy();
    expect($cancion->artists->pluck('id')->all())->toBe([$nuevo->id]);
});

test('eliminar una canción desvincula antes sus artistas', function () {
    $artista = Artist::factory()->create();
    $cancion = Song::factory()->create();
    $cancion->artists()->attach($artista);

    $this->delete(route('songs.destroy', $cancion))
        ->assertRedirect(route('songs.index'));

    expect(Song::find($cancion->id))->toBeNull();
    expect($artista->fresh()->songs)->toHaveCount(0);
});

test('un artista se registra, se edita y se elimina', function () {
    $this->post(route('artists.store'), [
        'name' => 'Artista de prueba',
        'genre' => 'Pop',
        'status' => '1',
    ])->assertRedirect(route('artists.index'));

    $artista = Artist::where('name', 'Artista de prueba')->firstOrFail();

    $this->put(route('artists.update', $artista), [
        'name' => 'Artista editado',
        'status' => '0',
    ])->assertRedirect(route('artists.index'));

    expect($artista->fresh()->name)->toBe('Artista editado');

    $this->delete(route('artists.destroy', $artista))
        ->assertRedirect(route('artists.index'));

    expect(Artist::find($artista->id))->toBeNull();
});

test('las páginas del panel responden sin error 500', function () {
    $cancion = Song::factory()->create();
    $artista = Artist::factory()->create();

    $this->get(route('songs.create'))->assertOk();
    $this->get(route('songs.show', $cancion))->assertOk();
    $this->get(route('songs.edit', $cancion))->assertOk();
    $this->get(route('artists.create'))->assertOk();
    $this->get(route('artists.show', $artista))->assertOk();
    $this->get(route('artists.edit', $artista))->assertOk();
});
