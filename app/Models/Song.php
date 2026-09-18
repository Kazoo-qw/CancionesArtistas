<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(['titulo', 'album', 'duration_in_seconds', 'release_date', 'genre', 'status', 'registered_by'])]
#[Hidden(['password', 'remember_token'])]
class Song extends Model
{
    use HasFactory; 

    protected $table = 'songs';
    protected $primaryKey = 'id';

     // Relación con Factura (uno a muchos) 
    public function artistSongs() 
    { 
        return $this->hasMany(artistSongs::class, 'song_id'); 
    } 

}
