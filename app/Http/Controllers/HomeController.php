<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // $movies = Movie::all()->sortByDesc(function($movie) {
        //     return $movie->ratings->avg('rating');
        // })->take(100);

        $movies = Movie::select('category_id', 'title', 'release_year')
            ->addSelect([
                'category_name' => Category::select('name')
                    ->whereColumn('category_id', 'categories.id')
            ])
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->limit(100)
            ->get();

        return view('home', compact('movies'));
    }
}
