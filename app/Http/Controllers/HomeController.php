<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::query()
            ->select(
                'movies.title',
                'movies.release_year',
                'categories.name as category_name',
                DB::raw('avg(`ratings`.`rating`) as `rating_avg`'),
                DB::raw('count(`ratings`.`rating`) as `rating_count`'),
            )
            ->join('categories', 'categories.id', '=', 'movies.category_id')
            ->join('ratings', 'ratings.movie_id', '=', 'movies.id')
            ->groupBy('movies.id')
            ->orderByDesc('rating_avg')
            ->orderBy('title')
            ->take(100)
            ->get();

        return view('home', compact('movies'));
    }
}
