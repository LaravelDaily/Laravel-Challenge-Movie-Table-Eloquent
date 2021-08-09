<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with(['category' => function($builder) {
            return $builder->select('id', 'name');
        }])->withAvg('ratings', 'rating')->withCount('ratings')->get(['title', 'release_year'])->sortByDesc(function($movie) {
            return $movie->ratings_avg_rating;
        })->take(100);

        return view('home', compact('movies'));
    }
}
