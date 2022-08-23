<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with('category')->withCount('ratings')->withAvg('ratings as ratings_avg', 'rating')->orderBy('ratings_avg', 'desc')->take(100)->get();

        return view('home', compact('movies'));
    }
}
