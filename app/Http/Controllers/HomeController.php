<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with('category:id,name')
            ->orderByDesc('ratings_avg_rating')
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->limit(100)
            ->get();

        return view('home', compact('movies'));
    }
}
