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

        $movies = Movie::with(['category', 'ratings'])
            ->take(100)
            ->get()
            ->sortByDesc(function ($movie) {
                return $movie->ratings->avg('rating');
            });

        return view('home', compact('movies'));
    }
}