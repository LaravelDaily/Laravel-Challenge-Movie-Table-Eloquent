<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with(['category' => function($builder) {
            return $builder->select('id', 'name');
        }])->withAvg('ratings', 'rating')->withCount('ratings')->take(100)->get(['title', 'release_year'])->sortByDesc('ratings_avg_rating');

        return view('home', compact('movies'));
    }
}
