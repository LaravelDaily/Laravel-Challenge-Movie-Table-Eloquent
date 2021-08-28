<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with('category')
                        ->withCount('ratings') //ratings_count
                        ->withAvg('ratings','rating') //ratings_avg_rating
                        ->orderByDesc('ratings_avg_rating')
                        ->take(100)
                        ->get();

        return view('home', compact('movies'));
    }
}
