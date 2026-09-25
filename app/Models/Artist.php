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


    public function songArtists(): HasMany
    {
        return $this->hasMany(SongArtist::class, 'artist_id');
    }
}