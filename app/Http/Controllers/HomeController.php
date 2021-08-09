<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::hydrate(DB::table('movies', 'm')
        ->leftJoin('categories AS c', 'm.category_id', '=', 'c.id')
        ->selectRaw('m.*, c.name AS category_name, AVG(r.rating) AS ratings_avg, COUNT(r.id) as ratings_count')
        ->leftJoin('ratings AS r', 'r.movie_id', '=', 'm.id')
        ->groupBy('m.id')
        ->limit(100)
        ->orderBy('ratings_avg')
        ->get()->toArray());

        return view('home', compact('movies'));
    }
}
