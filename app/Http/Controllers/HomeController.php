<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $movies = DB::table('movies')
            ->join('ratings', 'movies.id', '=', 'ratings.movie_id')
            ->join('categories', 'movies.category_id', '=', 'categories.id')
            ->select(
                'movies.title',
                'movies.release_year',
                'movies.title',
                'categories.name as category_name',
                DB::raw('count(ratings.rating) as rating_count'),
                DB::raw('AVG(ratings.rating) AS rating_average')
            )
            ->groupBy('movies.id')
            ->orderByDesc('rating_average')
            ->offset(0)
            ->limit(100)
            ->get();

        // ddd($movies);
        // $movies = Movie::with('ratings')->get()->sortByDesc(function ($movie) {
        //     return $movie->ratings->avg('rating');
        // })->take(100);

        return view('home', compact('movies'));
    }
}
