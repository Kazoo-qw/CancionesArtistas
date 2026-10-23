<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Song;
use App\Models\SongArtist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Song::factory()->count(20)->create();
        Artist::factory()->count(20)->create();

        SongArtist::factory(200)->create();
    }
}
