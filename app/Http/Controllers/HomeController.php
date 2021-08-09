<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::select('title', 'release_year')
                        ->withJoinCategory(['name'])
                        ->withJoinRating()
                        ->orderByDesc('rating_avg_rating')
                        ->take(100)
                        ->get();
        
        return view('home', compact('movies'));
    }
}
