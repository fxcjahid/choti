<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Series;
use App\Models\PostTags;
use App\Models\Categories;
use App\Models\PostSeries;
use Illuminate\Http\Request;
use App\Models\PostThumbnail;
use App\Models\PostCategories;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use fxcjahid\LaravelTableOfContent\table;
use fxcjahid\LaravelEditorJsHtml\BlocksManager;
use fxcjahid\LaravelTableOfContent\MarkupFixer;

class PostController extends Controller
{
    static $slug;

    public function index(Request $request)
    {
        $posts = Post::getAll()
            ->when(true, function ($query) use ($request) {

                $orderType = $request->get('orderBy');

                if (! empty($orderType)) {
                    /**
                     * Order By
                     */
                    switch ($orderType) {

                        case 'lastUpdate':
                            $query
                                ->where('updated_at', '>', now()->subDays(10)->endOfDay())
                                ->orderBy('updated_at', 'DESC');
                            break;

                        case 'name':
                            $query->orderBy('name');
                            break;

                        case 'asc':
                            $query->orderBy('id', 'ASC');
                            break;

                        case 'desc':
                            $query->orderBy('id', 'DESC');
                            break;

                        case 'views':
                            $query->orderByViews()->get();
                            break;

                        default:
                            $query->orderBy('id', 'DESC');
                            break;
                    }
                } else {
                    $query->orderBy('id', 'DESC');
                }
            })
            ->where(function ($query) use ($request) {

                $status = $request->get('status');

                if (! empty($status)) {
                    $query->where('status', '=', $status);
                }
            })
            ->paginate(25);  //get first 25 rows

        $statistics = Post::statistics();

        return view('admin.layout', compact('posts', 'statistics'));
    }

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
     * Show the articles page.
     * @return mixed
     */
    public function show($category, $slug, Table $toc, MarkupFixer $markup)
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

        /**
         * Make Hide useless arrtibutes
         */
        $suggestion->post->each(function ($each) {
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

    /**
     * Show post by slug or ID
     * @return $data
     */
    public function getPost($slug)
    {
        return Post::findBySlugOrID($slug);
    }

    /**
     * Show Create New Post Render
     *
     * @return @template
     */
    public function IndexCreatePost($find)
    {
        if (! Post::existSlugOrID($find)) {
            return redirect()->route('admin.dashboard')
                ->withErrors(['error' => 'The post doesn\'t exist']);
        }

        $post     = Post::findBySlugOrID($find)->makeHidden(['breadcrumb', 'comments']);
        $category = Categories::all();
        $series   = Series::all();
        $tags     = Tag::all();

        return view('admin.views.createpost', compact('post', 'category', 'series', 'tags'));
    }

    /**
     * Create New Post.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPost()
    {
        return Post::CreatePost();
    }

    /**
     * Post update
     */
    public function update(Request $request)
    {
        $postID = $request->id;

        $post         = Post::find($postID);
        $post->status = $request->status;

        if ($request->status == 'delete') {
            $post->forceDelete();
        } else {
            $post->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'The post was draft successfully.',
        ]);
    }

    /**
     * Update Post.
     * @param $post
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return @response
     */
    public function updatePost(StorePostRequest $request)
    {
        $postID = $request->id;

        $post          = Post::find($postID);
        $post->title   = $request->title;
        $post->slug    = $request->slug;
        $post->status  = $request->status;
        $post->content = $request->content;
        $post->summary = $request->summary;

        $this->updateTags($request->tag, $request->id);
        $this->updateCategories($request->category, $request->id);
        $this->updateSeries($request->series, $request->id);
        $this->updateThumbnail($request->thumbnail, $request->id);

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'The post was publish successfully.',
        ]);
    }

    /**
     * Update Post's Thumbnail
     */
    private function updateThumbnail(array $thumbnail = [], int $postID = null)
    {
        PostThumbnail::where('post_id', $postID)->delete();

        foreach ($thumbnail as $value) {
            PostThumbnail::create([
                'post_id' => $postID,
                'file_id' => $value['id'],
            ]);
        }
    }

    /**
     * Update Post's Tags.
     **/
    private function updateTags(array $tags = [], int $postID = null)
    {
        PostTags::where('post_id', $postID)->delete();

        foreach ($tags as $value) {
            PostTags::create([
                'post_id' => $postID,
                'tag_id'  => $value,
            ]);
        }
    }

    /**
     * Update Post's Categories.
     **/
    private function updateCategories(array $categories = [], int $postID = null)
    {
        PostCategories::where('post_id', $postID)->delete();

        foreach ($categories as $value) {
            PostCategories::create([
                'post_id'       => $postID,
                'categories_id' => $value,
            ]);
        }
    }

    /**
     * Update Post's Series.
     **/
    private function updateSeries(array $series = [], int $postID = null)
    {
        PostSeries::where('post_id', $postID)->delete();

        foreach ($series as $value) {
            PostSeries::create([
                'post_id'   => $postID,
                'series_id' => $value,
            ]);
        }
    }
}
