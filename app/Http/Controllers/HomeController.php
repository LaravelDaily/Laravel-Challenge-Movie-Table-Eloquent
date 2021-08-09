<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with(['ratings', 'category'])
            ->limit(100)
            ->get()
            ->sortByDesc(function ($movie) {
                return $movie->ratings->avg('rating');
            });

        return view('home', compact('movies'));
    }
}
