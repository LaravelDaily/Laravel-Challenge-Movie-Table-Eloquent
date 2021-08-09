<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::select('category_id', 'title', 'release_year')
            ->withCategory()
            ->withRatings(true)
            ->latest('ratings_avg')
            ->take(100)->get();

        return view('home', compact('movies'));
    }
}
