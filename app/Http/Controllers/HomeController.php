<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Original Eloquent
//         $movies = Movie::all()->sortByDesc(function($movie) {
//             return $movie->ratings->avg('rating');
//         })->take(100);

        // My better Eloquent
        $movies = Rating::groupBy(['movie_id', 'movies.title', 'categories.name', 'movies.release_year'])
            ->selectRaw('movies.title, categories.name as name, movies.release_year, avg(rating) as rating, count(rating) as vote')
            ->leftJoin('movies', 'movies.id', '=', 'ratings.movie_id')
            ->leftJoin('categories', 'movies.category_id', '=', 'categories.id')
            ->orderByRaw('AVG(rating) DESC')
            ->limit(100)
            ->get();

        // And my Query builder
//        $movies = DB::table('ratings')
//            ->selectRaw('movies.title, movies.release_year, categories.name as name, avg(rating) as rating, count(rating) as vote')
//            ->leftjoin('movies', 'ratings.movie_id', '=', 'movies.id')
//            ->leftjoin('categories', 'categories.id', '=', 'movies.category_id')
//            ->groupBy('movie_id', 'movies.title', 'categories.name', 'movies.release_year')
//            ->orderByRaw('AVG(rating) DESC')
//            ->limit(100)->get();

        return view('home', compact('movies'));
    }
}
