<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        /*$movies = Movie::all()->sortByDesc(function($movie) {
            return $movie->ratings->avg('rating');
        })->take(100);*/
        // fastest one
        // but I am going to do this with Eloquent
        $movies = DB::select("SELECT movie_id as `id`,title,categories.name as `category_name`,release_year,ratings_avg,ratings_cnt from (SELECT movie_id,title,release_year,category_id,ratings_avg,ratings_cnt from (SELECT `movie_id`, AVG(`rating`) as `ratings_avg` , COUNT(`movie_id`) as `ratings_cnt` FROM `ratings` GROUP BY `movie_id` ORDER BY `ratings_avg` DESC LIMIT 0 , 100) f1 INNER JOIN movies ON f1.movie_id = movies.id) f2 INNER JOIN categories ON f2.category_id = categories.id");

        return view('home', compact('movies'));
    }
}
