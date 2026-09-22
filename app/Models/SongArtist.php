<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable(['artist_id', 'song_id', 'status'])]
class SongArtist extends Pivot
{
    use HasFactory;

    protected $table = 'songs_artists';

    // A diferencia del comportamiento por defecto de Pivot (sin PK propia),
    // songs_artists tiene su propia columna `id` autoincremental.
    public $incrementing = true;
    protected $primaryKey = 'id';

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }
}