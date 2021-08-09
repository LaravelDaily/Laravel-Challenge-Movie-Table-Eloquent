<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with('ratings','category')->withCount('ratings')
            ->withAvg('ratings','rating')->take(100)->get();
/*dd($movies[0]);*/
        return view('home', compact('movies'));
    }
}
