<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->with('category:id,name')
            ->take(100)
            ->get()
            ->sortByDesc('ratings_avg_rating');

        return view('home', compact('movies'));
    }
}
