<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Helpers\BreadcrumbHelper;
use fxcjahid\LaravelEditorJsHtml\BlocksManager;

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
     * @param int|string $slug 
     */
    public function show($category, $slug)
    {
        $post = Post::findPublishPost($category, $slug);

        $breadcrumb = BreadcrumbHelper::forPost($post);

        $post->TrackViewRecord();

        return view(
            'public.post.index',
            compact(
                'post',
                'breadcrumb',
            ),
        );
    }

}