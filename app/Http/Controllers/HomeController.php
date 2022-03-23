<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Database\Query\JoinClause;

class HomeController extends Controller
{
    public function index()
    {
        /*$movies = Movie::all()->sortByDesc(function($movie) {
            return $movie->ratings->avg('rating');
        })->take(100);*/

        $rating_sub_query = Rating::query()
            ->join('movies', 'ratings.movie_id', '=', 'movies.id')
            ->groupBy('movie_id')
            ->selectRaw('AVG(rating) as average, COUNT(rating) as count, movie_id');

        $movies = Movie::query()
            ->select('title', 'release_year')
            ->joinSub($rating_sub_query, 'avg_rat', function (JoinClause $join) {
                $join->on('movies.id', '=', 'avg_rat.movie_id');
            })
            ->addSelect([
                'category_name' => Category::select('name')
                    ->whereColumn('id', 'movies.category_id')
                    ->limit(1)
            ])
            ->addSelect('average', 'count')
            ->orderByDesc('average')
            ->limit(100)
            ->get();

        return view('home', compact('movies'));
    }
}
