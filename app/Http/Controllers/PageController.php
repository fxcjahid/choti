<?php

namespace App\Http\Controllers;

use App\Models\Categories;

class PageController extends Controller
{
    public function guidesNuisibles()
    {
        $data = Categories::whereNotIn(
            'slug',
            ['prix']
        )
            ->where('is_active', true)
            ->with([
                'post' => function ($query) {
                    return $query->where('status', '=', 'publish')
                        ->with(
                            'category',
                            'thumbnail'
                        )
                        ->orderBy('name')->get();
                },
            ])
            ->withCount('post')
            ->orderBy('name')
            ->get()
            ->map(function ($query) {
                return $query->setRelation('post', $query->post->take(3));
            });

        /**
         * Make Hide useless arrtibutes
         */
        $data->each(function ($each) {
            $each->makeHidden([
                'user_id',
                'summary',
                'status',
                'parent_id',
                'description',
                'position',
                'is_active',
                'pivot',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
            $each->post->makeHidden([
                'user_id',
                'summary',
                'status',
                'pivot',
                'content',
                'created_at',
                'updated_at',
                'deleted_at',
                'body',
            ]);
        });

        return view('public.page.guides-nuisibles', compact('data'));
    }

    public function prix()
    {
        $data = Categories::whereIn(
            'slug',
            ['prix']
        )
            ->where('is_active', true)
            ->with([
                'post' => function ($query) {
                    return $query->where('status', '=', 'publish')
                        ->with(
                            'category',
                            'thumbnail'
                        )
                        ->orderBy('name')->get();
                },
            ])
            ->withCount('post')
            ->orderBy('name')
            ->get();

        return view('public.page.prix', compact('data'));
    }

    /**
     * Pest Controller Page
     */
    public function mice()
    {
        return view('public.page.service.mice-control');
    }

    /**
     * Page: Politique de confidentialité
     * En: Privacy Policy
     */
    public function PolitiqueConfidentialite()
    {
        return view('public.page.privacy-policy');
    }

    /**
     * Page: À Propos
     * En: About Us
     */
    public function AboutUs()
    {
        return view('public.page.about-us');
    }

    /**
     * Service Page
     */
    public function servicePage($page)
    {
        $basePath = 'public/page/service/' . $page;
        if (!view()->exists($basePath)) {
            return abort(404);
        }

        /**
         * Load page data
         */
        $load = @include resource_path('views/' . $basePath . '.php');

        /**
         * get page relate article
         */
        if (!empty($load['blog'])) {
            $category = $load['blog']['category'];
            $keyword  = $load['blog']['keyword'];
            $post     = Categories::with([
                'post' => function ($query) use ($keyword) {
                    $query
                        ->where('status', '=', 'publish')
                        ->where('name', 'like', $keyword)
                        ->limit(3);
                },
            ])
                ->where(
                    [
                        ['slug', '=', $category],
                        ['is_active', '=', true],
                    ]
                )
                ->first()
                ->makeHidden([
                    'user_id',
                    'parent_id',
                    'description',
                    'position',
                    'is_active',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]);

            /**
             * Make Hide useless arrtibutes for post
             */
            $post->post->each(function ($each) {
                return $each->makeHidden([
                    'user_id',
                    'summary',
                    'status',
                    'readTime',
                    'pivot',
                    'content',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'body',
                ]);
            });

            $load['blog']['post'] = $post->post;
        }

        return view(
            'public.page.service.layout',
            $load
        );
    }
}
