<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $movies = DB::table('ratings')
            ->join('movies', 'movies.id', '=', 'ratings.movie_id')
            ->join('categories', 'categories.id', '=', 'movies.category_id')
            ->select('movies.*', 'ratings.rating', 'categories.name as category_name')
            ->get()
            ->groupBy('title')
            ->map(function ($q) {
                return [
                    'title' => $q->first()->title,
                    'category_name' => $q->first()->category_name,
                    'release_year' => $q->first()->release_year,
                    'avg_rating' =>  number_format($q->avg('rating'),2) ,
                    'count_rating' => $q->count(),
                ];
            })
            ->take(100);
        return view('home', compact('movies'));
    }
}
