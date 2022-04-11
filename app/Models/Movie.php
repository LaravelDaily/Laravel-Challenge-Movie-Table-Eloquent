<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'title', 'release_year'];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($movie) {
            Cache::forget('movies.index');
        });

        self::updated(function ($movie) {
            Cache::forget('movies.index');
        });

        self::deleted(function ($movie) {
            Cache::forget('movies.index');
        });
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
