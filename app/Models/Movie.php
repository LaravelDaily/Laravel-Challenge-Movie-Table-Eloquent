<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

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

    public function scopeWithJoinRating(Builder $query, array $columns = [], string $alias = 'rating'): Builder
    {
        $select = $query->getQuery()->columns ?? ["{$this->getTable()}.*"];
        foreach($columns as $column) {
            $select[] = DB::raw("$alias.$column as {$alias}_{$column}");
        }
        $select[] = DB::raw("AVG({$alias}.rating) as {$alias}_avg_rating");
        $select[] = DB::raw("COUNT({$alias}.id) as {$alias}_count");
        return $query
                ->leftJoin("ratings as {$alias}", function(JoinClause $join) use($alias){
                    $join->on("{$alias}.movie_id", '=', "{$this->getTable()}.id");
                })
                ->groupBy("{$this->getTable()}.id")
                ->select($select);
    }

    public function scopeWithJoinCategory(Builder $query, array $columns = [], string $alias = 'category'): Builder
    {
        $select = $query->getQuery()->columns ?? ["{$this->getTable()}.*"];
        foreach($columns as $column) {
            $select[] = DB::raw("$alias.$column as {$alias}_{$column}");
        }
        return $query
                ->leftJoin("categories as {$alias}", function(JoinClause $join) use($alias){
                    $join->on("{$alias}.id", '=', "{$this->getTable()}.category_id");
                })
                ->select($select);
    }
}
