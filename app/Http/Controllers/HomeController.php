<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        // $movies = Movie::all()->sortByDesc(function($movie) {
        //     return $movie->ratings->avg('rating');
        // })->take(100);

//         $movies = Movie::with(['category', 'ratings'])
//             ->take(100)
//             ->get()
//             ->sortByDesc(function ($movie) {
//                 return $movie->ratings->avg('rating');
//             });
        
        // Changes made as pointed out by nipunTharuksha. Thanks nipunTharuksha. 
        // I got my wrong. I was whole loading the ratings that loaded 1050 models. 
        // Now need to change view too. So I have made changes to my view as well
        $movies = Movie::with('category')
                ->withAvg('ratings','rating')
                ->withCount('ratings')
                ->orderByDesc('ratings_avg_rating')
                ->limit(100)
                ->get();

        return view('home', compact('movies'));
    }
}
