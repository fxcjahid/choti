<?php

namespace App\Traits;

use App\Models\Tag;
use App\Models\File;
use App\Models\User;
use App\Models\Series;
use App\Models\Categories;
use App\Models\PostComments;

trait Relationship
{
    /**
     * Get post Creator
     * Relation between table
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get post Comments
     * Relation between table
     */
    public function comments()
    {
        return $this->hasMany(PostComments::class);
    }

    /**
     * Get post Categories
     * Relation between table
     */
    public function category()
    {
        return $this->belongsToMany(Categories::class, 'post_categories');
    }

    /**
     * Get post series
     * Relation between table
     */
    public function series()
    {
        return $this->belongsToMany(Series::class, 'post_series');
    }
    /**
     * Get post Tags
     * Relation between table
     */
    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    /**
     * Get post Thumbnail
     * Relation between table
     */
    public function thumbnail()
    {
        return $this->belongsToMany(File::class, 'post_thumbnails');
    }
}