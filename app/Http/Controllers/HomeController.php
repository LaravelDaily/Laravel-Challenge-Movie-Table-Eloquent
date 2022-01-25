<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
//        $movies = Movie::all()->sortByDesc(function($movie) {
//            return $movie->ratings->avg('rating');
//        })->take(100);

        $movies = DB::table('ratings')
            ->selectRaw('movies.id, title, avg(ratings.rating) as avg_rating, categories.name as category_name, release_year, count(*) as rating_count')
            ->join('movies', 'ratings.movie_id', '=', 'movies.id')
            ->join('categories', 'categories.id', '=', 'movies.category_id')
            ->groupBy('movies.id', 'title')
            ->orderByDesc('avg_rating')
            ->take(100)
            ->get();
        return view('home', compact('movies'));
    }
}
