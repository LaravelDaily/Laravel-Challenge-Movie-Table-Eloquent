<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    public function index()
    {
        /**
         * Original Query
         *  */ 
        //$movies = Movie::all()->sortByDesc(function($movie) {
        //    return $movie->ratings->avg('rating');
        //})->take(100);
        $movies = Movie::join('ratings','movies.id','=','ratings.movie_id')
                        ->join('categories','movies.category_id','=','categories.id')
                        ->select('movies.*','categories.*',DB::raw('AVG(ratings.rating) as avg_rating,COUNT(*) as Votes'))
                        ->groupBy('movies.id')
                        ->orderByRaw('avg(ratings.rating) DESC')->take(100)->get();

        return view('home', compact('movies'));
    }
}
