<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::query()
            ->with(['ratings', 'category'])
            ->get()
            ->sortByDesc(function($movie) {
                return $movie->ratings->avg('rating');
            })
            ->take(100);

        return view('home', compact('movies'));
    }
}
