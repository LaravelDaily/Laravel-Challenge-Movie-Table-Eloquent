<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {


        $movies = Movie::query() //Using query for the next functions to be indented
            ->select('id','category_id','title','release_year')
            ->with('category',function($query){
                $query->select('id','name');
            })
            ->withAvg('ratings','rating')
            ->withCount('ratings')
            ->take(100)
            ->get()
            ->sortByDesc('ratings_avg_rating');

        return view('home', compact('movies'));
    }
}
