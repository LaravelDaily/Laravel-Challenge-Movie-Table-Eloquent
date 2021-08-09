<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public function scopeByMovie($query)
    {
        return $query->selectRaw('movie_id, title, release_year, categories.name as category_name, COUNT(rating) as votes_count, AVG(rating) as rating_avg')
            ->join('movies', 'ratings.movie_id', '=', 'movies.id')
            ->join('categories', 'movies.category_id', '=', 'categories.id')
            ->orderByDesc('rating_avg')
            ->groupBy('movie_id')
            ->take(100)
            ->get();
    }
}
