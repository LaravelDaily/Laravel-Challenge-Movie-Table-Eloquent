<?php

namespace App\Models;

use DateTime;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'title', 'release_year'];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function topByRating()
    {
        return self::with('category')->orderByDesc('rating');
    }

    public function updateRatingsCache()
    {
        $this->rating = round($this->ratings->avg('rating'), 2);
        $this->rating_count = $this->ratings->count();
    }

    public static function updateAllRatingsCache(DateTimeInterface $since)
    {
        foreach(Movie::where('updated_at', '<=', $since)->lazy() as $movie) {
            $movie->updateRatingsCache();
            $movie->save();
        }
    }
}
