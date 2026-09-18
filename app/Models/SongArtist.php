<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['artist_id', 'song_id', 'status'])]
#[Hidden(['password', 'remember_token'])]
class SongArtist extends Model
{
    use HasFactory;

    protected $table = 'songs_artists';
    protected $primaryKey = 'id';

    // Relación con Artist (muchos a uno) 
    public function artist() 
    { 
        return $this->belongsTo(Artist::class); 
    } 
 
    // Relación con Song (muchos a uno) 
    public function song() 
    { 
        return $this->belongsTo(Song::class); 
    }
}