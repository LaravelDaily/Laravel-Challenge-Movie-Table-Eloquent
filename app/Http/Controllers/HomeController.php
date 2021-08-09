<?php

namespace App\Http\Controllers;

use App\Models\Rating;

class HomeController extends Controller
{
    public function index()
    {

        $ratings = Rating::groupBy('movie_id')
            ->selectRaw('movie_id,avg(rating) as average,count(rating) as count')
            ->orderByDesc('average')
            ->with(['movie' => function($q){
                return $q->with('category:id,name');
            }])
            ->take(100)
            ->get()
            ->toArray();

        return view('home', compact('ratings'));
    }
}
