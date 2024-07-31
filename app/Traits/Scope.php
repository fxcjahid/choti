<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait Scope
{
    /**
     * Scope a query to only include published query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWherePublished($query)
    {
        return $query->where('status', 'publish');
    }

    /**
     * Scope a query to include posts from a specific category and active status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereCategory($query, $slug)
    {
        return $query->with([
            'category' => function ($query) use ($slug) {
                $query
                    ->where('slug', '=', $slug)
                    ->where('is_active', '=', true)
                    ->firstOrFail();
            },
        ]);
    }

    public function scopeWithSeries($query)
    {
        return $query->with([
            'series.post' => function ($query) {
                $query->select('id', 'title', 'slug')
                    ->where('id', '!=', $this->id)
                    ->wherePublished();
            }
        ]);
    }

    public function scopeWithTag($query)
    {
        return $query->with('tag');
    }

    public function scopeWhereTag($query, $slug)
    {
        return $query->with([
            'tag' => function ($query) use ($slug) {
                $query
                    ->where('slug', '=', $slug)
                    ->where('is_active', '=', true)
                    ->firstOrFail();
            },
        ]);
    }

    public function scopeWithComments($query)
    {
        return $query->with('comments');
    }

    public function scopeWithThumbnail($query)
    {
        return $query->with('thumbnail');
    }
}