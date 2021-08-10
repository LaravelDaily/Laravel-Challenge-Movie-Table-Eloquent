<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::select('id', 'title', 'category_id', 'release_year')
            ->with('category:id,name')
            ->withCount('ratings as vote')
            ->withAvg('ratings as avg_rating', 'rating')
            ->orderByDesc('avg_rating')
            ->limit(100)
            ->get();

        return view('home', compact('movies'));
    }
}
