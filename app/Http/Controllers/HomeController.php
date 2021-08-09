<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use DB;

class HomeController extends Controller
{
    public function index()
    {

        /*$movies = Movie::all()->sortByDesc(function($movie) {
            return $movie->ratings->avg('rating');
        })->take(100); */

        $movies = DB::select("
            select m.title, c.name as category_name, m.release_year, v.ratings_avg, v.ratings_count
    from movies as m
      inner join categories as c on c.id=m.category_id
      left outer join (
        select movie_id, avg(rating) as ratings_avg, count(id) as ratings_count from ratings group by movie_id
        ) as v on v.movie_id=m.id
order by v.ratings_avg desc limit 100");

        return view('home', compact('movies'));
    }
}
