<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
//        $movies = Movie
//            ::join('categories', 'categories.id', 'movies.category_id')
//            ->select('*')
//            ->withAvg('ratings', 'rating')
//            ->withCount('ratings')
//            ->take(100)->orderBy('ratings_avg_rating', 'desc')->get();

        $movies = Movie
            ::with('category')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->take(100)->orderBy('ratings_avg_rating', 'desc')->get();

        return view('home', compact('movies'));
    }
}
