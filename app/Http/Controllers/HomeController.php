<?php

namespace App\Http\Controllers;

use App\Models\Rating;

class HomeController extends Controller
{
    public function index()
    {
       $movies = Rating::byMovie();

        return view('home', compact('movies'));
    }
}
