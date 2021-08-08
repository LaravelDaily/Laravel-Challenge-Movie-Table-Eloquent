<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // $movies = Movie::all()->sortByDesc(function($movie) {
        //     return $movie->ratings->avg('rating');
        // })->take(100);

        $movies = DB::table('movies')
            ->join('categories', 'categories.id', '=', 'movies.category_id')
            ->join('ratings', 'ratings.movie_id', '=', 'movies.id')
            ->selectRaw(
                'movies.id,'.
                'movies.release_year,'.
                'movies.title,'.
                'categories.name AS category_name,'.
                'AVG(ratings.rating) AS ratings,'.
                'COUNT(ratings.*) AS ratings_count'
            )
            ->orderByRaw('avg(ratings.rating) DESC')
            ->groupBy('movies.id', 'categories.id')->limit(100)->get();

        return view('home', compact('movies'));
    }
}
