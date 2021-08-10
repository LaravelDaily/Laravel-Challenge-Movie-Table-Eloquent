<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // $movies = Movie::get()->sortByDesc(function ($movie) {
        //     return $movie->ratings->avg('rating');
        // })->take(10);


        $movies = DB::table('movies')
            ->join('categories', 'categories.id', '=', 'movies.category_id')
            ->join('ratings', 'ratings.movie_id', '=', 'movies.id')
            ->select('movies.title', 'movies.release_year', 'categories.name as categoryName', DB::raw('round(AVG(ratings.rating),0) as rating ,round(count(ratings.rating),0) as rating_count '))
            ->groupBy('categories.name', 'movies.title', 'movies.release_year')
            ->get();

        //dd($movies);

        //$movies =  Movie::with(['category', 'ratings'])->get();


        return view('home', compact('movies'));
    }
}
