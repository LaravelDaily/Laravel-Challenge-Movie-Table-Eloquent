<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $topByRating=Movie::withAvg('ratings','rating')
            ->orderBy('ratings_avg_rating', 'desc')
            ->take(100);

        $movies=DB::table($topByRating,'top')
            ->select([
                'title',
                'name as category_name',
                'release_year',
                'ratings_avg_rating',
                DB::raw('(SELECT COUNT(r.id) from ratings as r where movie_id=top.id) as ratings_count')
            ])
            ->join('categories','categories.id','category_id')
            ->get();

        return view('home', compact('movies'));
    }
}
