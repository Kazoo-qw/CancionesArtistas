<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Song;
use App\Models\SongArtist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Conteos reales del panel de control.
        $totalCanciones = Song::count();
        $totalArtistas = Artist::count();
        $totalAsociaciones = SongArtist::count();

        return view('home', compact('totalCanciones', 'totalArtistas', 'totalAsociaciones'));
    }
}
