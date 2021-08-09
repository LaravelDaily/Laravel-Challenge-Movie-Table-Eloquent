<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::query()
            ->with('ratings', 'category')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderBy('ratings_avg_rating', 'desc')
            ->limit(100)
            ->get();

        return view('home')->with('movies', $movies);
    }
}
