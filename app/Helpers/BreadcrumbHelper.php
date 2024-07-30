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
    public static function category(Categories $category)
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

    public static function forPost(Post $post)
    {
        $breadcrumbs = self::category($post->category[0]);

        $breadcrumbs[] = ['title' => $post->title, 'url' => null];

        return $breadcrumbs;
    }
}