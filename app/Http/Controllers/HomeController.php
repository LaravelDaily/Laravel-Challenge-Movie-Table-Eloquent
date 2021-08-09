<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // The query is a little bit large so commenting here for easy reference.
        //
        // What we are doing here is taking advantage of sub-query as our main
        // reference table. Since from the sub-query we already limited the data
        // to the top 100, all we had to do is join it further and that will
        // take care of the mapping for the rest of the needed data.
        //
        // SELECT movies.title, movies.release_year, categories.name, top100.ave_rating
        // FROM (
        //     SELECT AVG(rating) ave_rating, movie_id
        //     FROM ratings
        //     GROUP BY movie_id
        //     ORDER BY ave_rating DESC
        //     LIMIT 100
        // ) top100
        // JOIN movies ON movies.id = top100.movie_id
        // JOIN categories ON categories.id = movies.category_id;

        $topX = config('app.highest_rated_movies_count');

        $ratingAvgQuery =  DB::table('ratings')
            ->selectRaw('AVG(rating) ave_rating, movie_id, COUNT(1) votes')
            ->groupBy('movie_id')
            ->orderBy('ave_rating', 'desc')
            ->limit($topX)
        ;

        $rankedMovies =DB::table(DB::raw("({$ratingAvgQuery->toSql()}) as ranked_ratings"))
            ->select('movies.title', 'movies.release_year', 'ranked_ratings.ave_rating', 'ranked_ratings.votes', 'categories.name AS category_name')
            ->join('movies', 'movies.id', '=', 'ranked_ratings.movie_id')
            ->join('categories', 'categories.id', '=', 'movies.category_id')
            ->get()
        ;

        return view('home', compact('rankedMovies', 'topX'));

    }
}
