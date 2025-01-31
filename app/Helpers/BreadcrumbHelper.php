<?php

namespace App\Helpers;


use App\Models\Post;
use App\Models\Categories;

class BreadcrumbHelper
{
    /**
     * Generate from categories
     * @param \App\Models\Categories $category
     * @return array
     */
    public static function category($category)
    {
        $breadcrumbs = [];

        while ($category) {
            array_unshift($breadcrumbs, [
                'title' => $category->name,
                'url'   => route('category', ['category' => $category->slug]),
            ]);
            $category = $category->parent;
        }

        // array_unshift($breadcrumbs, ['title' => 'Home', 'url' => route('home')]);

        return $breadcrumbs;
    }

    public static function series($series)
    {
        return [
            [
                'title' => $series->name,
                'url'   => route('series', $series->slug),
            ],
        ];
    }

    public static function tag($tag)
    {
        return [
            [
                'title' => $tag->name,
                'url'   => route('tag', $tag->slug),
            ],
        ];
    }

    public static function forPost(Post $post, $type)
    {
        $category = $post->category->where('slug', $type)->first();
        $series   = $post->series->where('slug', $type)->first();
        $tag      = $post->tag->where('slug', $type)->first();


        $breadcrumbs = match ($type) {
            $tag?->slug    => self::tag($tag),
            $series?->slug    => self::series($series),
            $category?->slug    => self::category($category),
            default => self::category($post->category->first())
        };

        $breadcrumbs[] = ['title' => $post->title, 'url' => null];

        return $breadcrumbs;
    }
}
