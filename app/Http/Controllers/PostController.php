<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
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
     * Replace post content to HTML view useing Block-editor
     * Wrap content by views
     */
    private function content($content)
    {
        $blocksManager = new BlocksManager($content);

        return $blocksManager->renderHtml();
    }

    /**
     * Display the specified resource.
     *
     * @param int|string $slug 
     */
    public function show($category, $slug)
    {
        $post    = Post::findPublishPost($category, $slug);
        $related = Post::related($post);
        $content = $this->content($post->content);

        /**
         * Old Dynamic suggestion related by post
         */
        //$suggestion = Post::suggestion($post);

        /**
         * Manual suggestion to show every single post as selected
         */
        $suggestion = Tag::whereIn(
            'slug',
            ['suggestion'],
        )
            ->where('is_active', true)
            ->with([
                'post' => function ($query) {
                    return $query->where('status', '=', 'publish')
                        ->with(
                            'category',
                            'thumbnail',
                        )
                        ->orderBy('name')->get();
                },
            ])
            ->withCount('post')
            ->first();


        $breadcrumb = [
            [
                'title' => 'Guides Anti-nuisibles',
                'url'   => route('guides-nuisibles'),
            ],
            [
                'title' => $post->category[0]->name,
                'url'   => route('category', ['category' => $post->category[0]->slug]),
            ],
            [
                'title' => $post->name,
                'url'   => $post->slug,
            ],
        ];

        return view(
            'public.post.layout',
            compact(
                'post',
                'content',
                'related',
                'breadcrumb',
                'suggestion',
            ),
        );
    }

}