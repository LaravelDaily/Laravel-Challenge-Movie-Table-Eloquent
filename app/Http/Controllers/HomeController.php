<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // $movies = $this->eloquentSolution();
        $movies = $this->dbSolution();

        return view('home', compact('movies'));
    }

    /**
     * 100 models
     * 1 query
     */
    private function eloquentSolution()
    {
        return Movie::query()
            ->select(
                'movies.title',
                'movies.release_year',
                'categories.name as category_name',
            )
            ->join('categories', 'categories.id', 'movies.category_id') // belongsTo relationship can be traded for a simple inner join since category_id is not nullable. If category_id was nullable, a left join would be needed instead.
            ->withCount('ratings')
            ->withAggregate('ratings as ratings_avg', 'round(avg(rating), 2)')
            ->orderBy('rating')
            ->limit(100)
            ->cursor() // return result as lazy collection.
            ->all();   // go from lazy collection to array.
    }

    /**
     * 0 models
     * 1 query
     */
    private function dbSolution()
    {
        $aggregate_count = DB::query()
            ->selectRaw('count(r.id)')
            ->from('ratings', 'r')
            ->whereColumn('m.id', 'r.movie_id');

        $aggregate_avg = DB::query()
            ->selectRaw('round(avg(r.rating), 2)')
            ->from('ratings', 'r')
            ->whereColumn('m.id', 'r.movie_id');

        return $movies = DB::query()
            ->select(
                'm.title',
                'm.release_year',
                'c.name as category_name',
            )
            ->selectSub($aggregate_count, 'ratings_count') // here $aggregate_count could be replaced with a Closure. I find this more readable.
            ->selectSub($aggregate_avg, 'ratings_avg')     // here $aggregate_avg could be replaced with a Closure. I find this more readable.
            ->from('movies', 'm')
            ->join('categories as c', 'c.id', 'm.category_id')
            ->limit(100)
            ->cursor() // return result as lazy collection.
            ->all();   // go from lazy collection to array.
    }
}
