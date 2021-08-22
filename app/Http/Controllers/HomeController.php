<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::query()
            ->with('category')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->take(100)
            ->latest('ratings_avg_rating')
            ->get();

        return view('home', compact('movies'));
    }
}
