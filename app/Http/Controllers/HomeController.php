<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderBy('ratings_avg_rating', 'desc')
            ->addSelect([
                'category_name' => \App\Models\Category::select('name')
                    ->whereColumn('category_id', 'categories.id')
            ])
            ->limit(100)
            ->get();

        return view('home', compact('movies'));
    }
}
