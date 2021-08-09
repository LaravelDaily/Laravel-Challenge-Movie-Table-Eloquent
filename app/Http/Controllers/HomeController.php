<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with('category')
            ->take(100)
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->get();

        return view('home', compact('movies'));
    }
}
