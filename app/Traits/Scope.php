<?php

namespace App\Traits;

use App\Helpers\BreadcrumbHelper;
use Butschster\Head\Facades\Meta;
use Illuminate\Database\Eloquent\SoftDeletes;
use Butschster\Head\Contracts\MetaTags\MetaInterface;

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

    /**
     * Track model view count to database
     * @param mixed $query
     * @return mixed
     */
    public function scopeTrackViewRecord()
    {
        return views($this)->record();
    }

    /**
     * Generated Meta Tags for model
     * @return Meta
     */
    public function scopeMetas()
    {
        $meta = new Meta();

        $meta::setTitle($this->title);

        if (
            $this instanceof \Illuminate\Pagination\Paginator ||
            $this instanceof \Illuminate\Pagination\LengthAwarePaginator ||
            method_exists($this, 'links')
        ) {
            $meta::setPaginationLinks($this);
        }

        if ($this->previous()) {
            $meta::setPrevHref(
                $this->previous()->url(),
            );
        }

        if ($this->next()) {
            $meta::setNextHref(
                $this->next()->url(),
            );
        }

        if ($this->url()) {
            $meta::setCanonical(
                $this->url(),
            );

            $meta::setHrefLang(app()->getLocale(), $this->url());
        }

        if (! empty($this->tag->pluck('name')->toArray())) {
            $meta::setKeywords(
                $this->tag->pluck('name')->toArray(),
            );
        }

        if (! empty($this->summary)) {
            $meta::setDescription($this->summary);
        }

        return $meta;
    }


}