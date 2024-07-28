<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\City;
use App\Models\Company;
use App\Models\Content;
use Illuminate\Support\Arr;

class ServiceController extends Controller
{

    /**
     * Get page data
     * @return array
     */
    private function loadPageCollection($service, $page)
    {
        /**
         * Check base template is exits
         */
        $basePath = 'public/page/service/' . $service;
        if (!view()->exists($basePath)) {
            return abort(404);
        }

        /**
         * Check & get city data
         */
        $city = City::where('city_slug', $page)->firstOrFail();

        /**
         * Load page data
         */
        $collection = @include resource_path('views/' . $basePath . '.php');

        /**
         * Get content from db
         */
        $content = new Content(
            $page,
            $service,
            $collection['content']
        );

        /**
         * Load suggestion service
         */
        $collection['service'] = $this->loadServiceItem($service);

        /**
         * Load post data
         */
        if (!empty($collection['blog'])) {

            $collection['blog']['post'] = $this->loadPageArticles(
                $collection['blog']['category'],
                $collection['blog']['keyword']
            );

        }

        /**
         * Merge collection
         */
        $collection = collect($collection)->mergeRecursive($content->instance);

        /**
         * Replace variable
         */
        $load = str_replace(
            [
                '{{city}}',
                '{{city_code}}',
            ],
            [
                $city->city_name,
                $city->zip_code,
            ],
            json_encode($collection)
        );

        $load = collect(
            json_decode($load)
        );

        /**
         * City Variable
         */
        $load['city'] = $city;

        /**
         * Company List
         */
        $load['companies'] = $this->loadCompany($city, $load);

        return $load->toArray();
    }

    /**
     * Suggest company items
     */
    private function loadCompany($city, $load)
    {
        $company = Company::where(function ($query) use ($city, $load) {
            $query
                ->where('city_name', '=', "%{$city->city_name}%");

            $multipleKey = explode(',', $load['company']->pest);

            if (!empty($multipleKey) && !empty($load['company']->pest)) {
                $query->whereIn('pest_name', $multipleKey);
            } else {
                if (!empty($load['company']->pest)) {
                    $query->where('pest_name', '=', "%{$load['company']->pest}%");
                }

            }
        })
            ->orWhere(function ($query) use ($city, $load) {
                $query
                    ->where('department_code', '=', $city->department_code);

                $multipleKey = explode(',', $load['company']->pest);

                if (!empty($multipleKey) && !empty($load['company']->pest)) {
                    $query->whereIn('pest_name', $multipleKey);
                } else {
                    if (!empty($load['company']->pest)) {
                        $query->where('pest_name', '=', "%{$load['company']->pest}%");
                    }

                }
            })
            ->orWhere(function ($query) use ($city, $load) {
                $query
                    ->where('region_name', '=', $city->region);

                $multipleKey = explode(',', $load['company']->pest);

                if (!empty($multipleKey) && !empty($load['company']->pest)) {
                    $query->whereIn('pest_name', $multipleKey);
                } else {
                    if (!empty($load['company']->pest)) {
                        $query->where('pest_name', '=', "%{$load['company']->pest}%");
                    }

                }
            })
            ->orWhere(function ($query) use ($city, $load) {
                if (!empty($multipleKey) && !empty($load['company']->pest)) {
                    $query->whereIn('pest_name', $multipleKey);
                } else {
                    if (!empty($load['company']->pest)) {
                        $query->where('pest_name', '=', "%{$load['company']->pest}%");
                    }

                }
            })
            ->orderBy('business_name')
            ->limit(30)
            ->get();

        $company = $company
            ->unique('business_name') // Remove Duplicate
            ->sortBy('business_name', SORT_NATURAL)
            ->sortBy('city_code', SORT_NUMERIC)
            ->take(5)
            ->all();

        return $company;
    }

    /**
     * Suggest related artices
     */
    private function loadPageArticles($category, $keyword)
    {
        $post = Categories::with([
            'post' => function ($query) use ($keyword) {
                $query
                    ->where('status', '=', 'publish')
                    ->where('name', 'like', $keyword)
                    ->with(
                        'category',
                        'thumbnail'
                    )
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

        return $post->post;
    }

    /**
     * Suggestion Service item
     */
    private function loadServiceItem($service)
    {

        $item = [
            [
                "name" => "Traitement souris {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-souris.png'),
                "url"  => 'traitement-souris',
            ],
            [
                "name" => "Dératisation {{city}}",
                "icon" => asset('assets/public/img/landing/deratisation-urgence.png'),
                "url"  => 'deratisation-urgence',
            ],
            [
                "name" => "Traitement punaises de lit {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-punaises-de-lit.png'),
                "url"  => "traitement-punaises-de-lit",
            ],
            [
                "name" => "Traitement puces {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-puces.png'),
                "url"  => "traitement-puces",
            ],
            [
                "name" => "Traitement cafards {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-cafards.png'),
                "url"  => "traitement-cafards",
            ],
            [
                "name" => "Traitement fourmis {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-fourmis.png'),
                "url"  => "traitement-fourmis",
            ],
            [
                "name" => "Traitement poissons d'argent {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-poissons-dargent.png'),
                "url"  => "traitement-poissons-dargent",
            ],
            [
                "name" => "Traitement araignées {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-araignees.png'),
                "url"  => "traitement-araignees",
            ],
            [
                "name" => "Traitement vers à bois {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-vers-a-bois-insectes-xylophages.png'),
                "url"  => "traitement-vers-a-bois-insectes-xylophages",
            ],
            [
                "name" => "Traitement mites {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-mites.png'),
                "url"  => "traitement-mites",
            ],
            [
                "name" => "Destruction nid de guêpes et frelons {{city}}",
                "icon" => asset('assets/public/img/landing/destruction-enlevement-nid-guepes-frelons.png'),
                "url"  => "destruction-enlevement-nid-guepes-frelons",
            ],
            [
                "name" => "Dépigeonnage {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-oiseaux-depigeonnage.png'),
                "url"  => "traitement-oiseaux-depigeonnage",
            ],
            [
                "name" => "Traitement mouches {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-professionnel-mouches.png'),
                "url"  => "traitement-professionnel-mouches",
            ],
            [
                "name" => "Traitement anthrènes des tapis {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-anti-anthrene-des-tapis.png'),
                "url"  => "traitement-anti-anthrene-des-tapis",
            ],
            [
                "name" => "Traitement renards {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-renards.png'),
                "url"  => "traitement-renards",
            ],
            [
                "name" => "Traitement vapeur punaises de lit {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-vapeur-punaises-de-lit.png'),
                "url"  => "traitement-vapeur-punaises-de-lit",
            ],
            [
                "name" => "Inspection nuisibles {{city}}",
                "icon" => asset('assets/public/img/landing/inspection-nuisibles.png'),
                "url"  => "inspection-nuisibles",
            ],
            [
                "name" => "Traitement insectes et rongeurs dans les entreprises {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-nuisibles-entreprises.png'),
                "url"  => "traitement-nuisibles-entreprises",
            ],
            [
                "name" => "Traitement insectes et rongeurs dans les restaurants {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-nuisibles-restaurants.png'),
                "url"  => "traitement-nuisibles-restaurants",
            ],
            [
                "name" => "Traitement insectes et rongeurs dans les bureaux {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-nuisibles-bureaux.png'),
                "url"  => "traitement-nuisibles-bureaux",
            ],
            [
                "name" => "Traitement insectes et rongeurs dans les entrepôts {{city}}",
                "icon" => asset('assets/public/img/landing/traitement-nuisibles-entrepots.png'),
                "url"  => "traitement-nuisibles-entrepots",
            ],
        ];

        $items = collect($item)
            ->whereNotIn('url', $service);

        return $items->all();
    }

    /**
     * Manage coverage page
     */
    public function coverage($service)
    {
        $region = City::all()
            ->groupBy('region');

        /**
         * Check base template is exits
         */
        $basePath = 'public/page/service/' . $service;
        if (!view()->exists($basePath)) {
            return abort(404);
        }

        /**
         * Load page data
         */
        $load = @include resource_path('views/' . $basePath . '.php');

        return view('public.page.service.coverage', compact('load', 'region'));
    }

    public function page($service, $page)
    {

        $load = $this->loadPageCollection($service, $page);

        return view(
            'public.page.service.layout',
            $load
        );
    }
}
