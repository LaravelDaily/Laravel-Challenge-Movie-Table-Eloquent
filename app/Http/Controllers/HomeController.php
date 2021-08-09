<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::selectRaw('movies.title, categories.name as category_name, movies.release_year,
                CAST(AVG(ratings.rating) AS DECIMAL(10,2)) as avg_rating, COUNT(ratings.rating) as ratings_count')
            ->leftJoin('categories', 'categories.id', '=', 'movies.category_id')
            ->leftJoin('ratings', 'ratings.movie_id', '=', 'movies.id')
            ->groupBy(DB::raw('movies.id'))
            ->orderByDesc(DB::raw('avg_rating'))
            ->take(100)
            ->get();

        return view('home', compact('movies'));
    }
}
