<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        // SOLUTION 1 USING ELOQUENT MODEL 2 queries 100 model

        // $query = Movie::query();

        // $movies = $query->addSelect(['cat_name' => Category::select('name')
        // ->whereColumn('id', 'movies.category_id')])
        // ->withAvg('ratings','rating')
        // ->withCount('ratings')
        // ->orderBy('ratings_count','DESC')
        // ->take(100)->get();


        // OR

        // SOLUTION 2 USIN DB RAW QUERY THE FASTEST WAY TO GET THE RESULTS

        $movies =  DB::select(DB::raw("SELECT movies.id as id,movies.title as title, movies.release_year as release_year,AVG(ratings.rating) as ratings_avg_rating, count(ratings.id) as ratings_count ,(categories.name) as cat_name
        FROM movies
        INNER JOIN categories on movies.category_id = categories.id
        INNER JOIN ratings on ratings.movie_id = movies.id
        GROUP BY ratings.movie_id
        ORDER BY ratings_count DESC limit ?
        "),[100]);


        return view('home', compact('movies'));
    }
}
