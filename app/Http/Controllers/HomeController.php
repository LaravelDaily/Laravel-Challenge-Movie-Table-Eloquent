<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with(['category', 'ratings'])
            ->withCount(['ratings as average_rating' => function($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
            }])
            ->orderByDesc('average_rating')
            ->limit(100)
            ->get();

        return view('home', compact('movies'));
    }
}
