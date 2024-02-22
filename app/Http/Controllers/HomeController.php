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

        $movies = Movie::with('category:id,name')
                        ->withCount('ratings')
                        ->withAvg('ratings','rating')
                        ->orderByDesc('ratings_avg_rating')   
                        ->take(100)
                        ->get();                   
        return view('home', compact('movies'));
    }
}
