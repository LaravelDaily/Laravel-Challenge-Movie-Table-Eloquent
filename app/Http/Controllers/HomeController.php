<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Rating;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::addSelect([
            'category_name' => Category::select('name')->whereColumn('id', 'movies.category_id')
            ])->withCount('ratings')->withAvg('ratings','rating')
            ->take(100)->get()->sortByDesc('ratings_avg_rating');
        
        return view('home', compact('movies'));
    }
}
