<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        // $movies = Movie::all()->sortByDesc(function($movie) {
        //     return $movie->ratings->avg('rating');
        // })->take(100);

        $movies = Movie::with('category')
            ->withCount('ratings')->withAvg('ratings', 'rating')
            ->limit(100)->get()->sortByDesc('ratings_avg_rating');

        return view('home', compact('movies'));
    }
}
