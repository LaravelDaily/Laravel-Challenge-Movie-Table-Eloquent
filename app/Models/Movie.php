<?php

namespace App\Models;

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

    public function scopeWithCategory($builder)
    {
        return $builder->with(['category' => fn ($q) => $q->select('name', 'id')]);
    }

    public function scopeWithRatings($builder, bool $withCount = null)
    {
        return $builder->withAvg('ratings', 'rating')
            ->when($withCount, fn ($q) => $q->withCount('ratings'));
    }
}
