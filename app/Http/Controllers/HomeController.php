<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $movies = DB::table('ratings')
            ->selectRaw('movie_id, title, release_year, categories.name as category_name, COUNT(rating) as votes, AVG(rating) as rating')
            ->join('movies', 'ratings.movie_id', '=', 'movies.id')
            ->join('categories', 'movies.category_id', '=', 'categories.id')
            ->orderByDesc('rating')
            ->groupBy('movie_id')
            ->take(100)
            ->get();

        return view('home', compact('movies'));
    }
}
