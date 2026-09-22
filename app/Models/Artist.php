<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'genre', 'bio', 'country', 'image_path', 'status', 'registered_by'])]
class Artist extends Model
{
    use HasFactory;

    protected $table = 'artists';
    protected $primaryKey = 'id';

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(Song::class, 'songs_artists', 'artist_id', 'song_id')
            ->using(SongArtist::class)
            ->withPivot('id', 'status')
            ->withTimestamps();
    }

    public function songArtists(): HasMany
    {
        return $this->hasMany(SongArtist::class, 'artist_id');
    }
}