<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::topByRating()->take(100)->get();

        return view('home', compact('movies'));
    }
}
