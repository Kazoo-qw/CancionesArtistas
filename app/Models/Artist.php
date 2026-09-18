<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(['name', 'genre', 'bio', 'country', 'image_path', 'status', 'registered_by'])]
#[Hidden(['password', 'remember_token'])]
class Artist extends Model
{
    use HasFactory; 

    protected $table = 'artists';
    protected $primaryKey = 'id';

     // Relación con Artist (uno a muchos) 
    public function artistSongs() 
    { 
        return $this->hasMany(artistSongs::class, 'songs_id'); 
    } 

}
