<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $movies = DB::table('movies')
            ->select('movies.*', 'categories.name as category_name')
            ->selectRaw('COUNT(rating) as ratings_count, AVG(rating) as ratings_avg_rating')
            ->join('categories', 'movies.category_id', '=', 'categories.id')
            ->leftJoin('ratings', 'movies.id', '=', 'ratings.movie_id')
            ->groupBy('movies.id')
            ->orderByDesc('ratings_avg_rating')
            ->take(100)
            ->get();

        return view('home', compact('movies'));
    }
}
