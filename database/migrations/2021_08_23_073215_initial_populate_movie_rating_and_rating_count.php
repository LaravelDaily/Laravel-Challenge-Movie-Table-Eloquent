<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Movie;

class InitialPopulateMovieRatingAndRatingCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(Movie::cursor() as $movie) {
            $movie->rating = round($movie->ratings->avg('rating'), 2);
            $movie->rating_count = $movie->ratings->count();
            $movie->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach(Movie::cursor() as $movie) {
            $movie->rating = 0;
            $movie->rating_count = 0;
            $movie->save();
        }
    }
}
