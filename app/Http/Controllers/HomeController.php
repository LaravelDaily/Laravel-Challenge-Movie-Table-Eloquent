<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        if (! Cache::has('movies.index')) {
            $movies = Cache::remember('movies.index', 86400, function () {
                $movies = Movie::query()
                    ->with('category')
                    ->withAvg('ratings', 'rating')
                    ->withCount('ratings')
                    ->orderByDesc('ratings_avg_rating')
                    ->take(100)
                    ->get();
    
                return $movies;
            });
        }

        if (Cache::has('movies.index')) {
            $movies = Cache::get('movies.index');
        }

        return view('home', compact('movies'));
    }
}
