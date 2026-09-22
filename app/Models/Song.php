<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'album', 'duration_in_seconds', 'release_date', 'genre', 'status', 'registered_by'])]
class Song extends Model
{
    use HasFactory;

    protected $table = 'songs';
    protected $primaryKey = 'id';

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'duration_in_seconds' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'songs_artists', 'song_id', 'artist_id')
            ->using(SongArtist::class)
            ->withPivot('id', 'status')
            ->withTimestamps();
    }

    public function songArtists(): HasMany
    {
        return $this->hasMany(SongArtist::class, 'song_id');
    }
}