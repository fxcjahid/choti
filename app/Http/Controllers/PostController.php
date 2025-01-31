<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Helpers\BreadcrumbHelper;
use Butschster\Head\Facades\Meta;
use Illuminate\Support\Facades\Cache;
use CyrildeWit\EloquentViewable\Support\Period;

class PostController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'post.post';

    /**
     * Route prefix.
     *
     * @var string
     */
    protected $routePrefix = 'post';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'public.post';


    /**
     * Display the specified resource.
     *
     * Cache::forget("post_{$category}_{$slug}");
     * Cache::forget("breadcrumb_post_{$post->id}");
     * @param int|string $slug
     */
    public function show($type, $slug)
    {
        $post = Cache::remember("post_{$type}_{$slug}", now()->addYear(), function () use ($type, $slug) {
            return Post::findPublishPost($type, $slug);
        });

        if (! $post) {
            abort(404);
        }

        $post->TrackViewRecord();

        $breadcrumb = Cache::remember("breadcrumb_post_{$post->id}_{$type}", now()->addDay(),
            fn () => BreadcrumbHelper::forPost($post, $type)
        );

        $post->Metas();

        return view('public.post.index', compact('post', 'breadcrumb'));
    }

    public function mostViews(Request $request)
    {
        $currentPage = $request->get('page', 1);
        $cacheKey    = "most_viewed_posts_weekly_page_{$currentPage}";

        $posts = Cache::remember($cacheKey, now()->addWeek(), function () {
            return Post::whereIn('id', Post::topViewed()->pluck('id'))
                ->orderByViews('desc', Period::pastWeeks(1))
                ->paginate(10);
        });

        $categorylist = Categories::where('is_active', true)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        Meta::setTitle('বাংলা জনপ্ৰিয় চটি গল্প | bangla choti golpo')
            ->setDescription(__('app.description'))
            ->setKeywords(__('app.keyword'))
            ->setCanonical(request()->url());


        return view('public.most-views.show', compact('posts', 'categorylist'));
    }

}
