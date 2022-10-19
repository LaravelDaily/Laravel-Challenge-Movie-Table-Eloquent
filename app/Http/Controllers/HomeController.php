<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderBy('ratings_avg_rating', 'desc')
            ->take(100)->get();
        $movies->load('category');
        return view('home', compact('movies'));
    }
}
