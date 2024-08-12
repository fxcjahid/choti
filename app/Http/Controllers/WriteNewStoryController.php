<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Series;
use App\Models\PostTags;
use App\Models\Categories;
use App\Models\PostSeries;
use App\Models\PostThumbnail;
use App\Models\PostCategories;
use App\Traits\HasCrudActions;
use App\Http\Controllers\FileController;
use App\Http\Requests\WriteNewStoryRequest;
use App\Http\Requests\WriteNewStoryUpdateRequest;

class WriteNewStoryController extends Controller
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
    protected $label = 'story.story';

    /**
     * Route prefix.
     *
     * @var string
     */
    protected $routePrefix = 'story';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'public.story';


    /**
     * Validation of the resource.
     *
     * @var string
     */
    protected $validation = WriteNewStoryRequest::class;



    /**
     * Display the index view of the story resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('public.account.create-story');
        }

        return view('public.story.index');
    }

    /**
     * Store a newly created story in the storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $entity = $this->getModel()->create(
            $this->getRequest('store')->all(),
        );

        $postIds   = unserialize(
            request()
                ->cookie('post', serialize([])),
        );
        $postIds[] = $entity->id;
        $postIds   = array_unique($postIds);

        $cookie = cookie()->forever('post', serialize($postIds));

        $encodedId = base64_encode($entity->id);

        return redirect()
            ->route('public.story.success', ['id' => $encodedId])
            ->withCookie($cookie);
    }


    /**
     * Display the success view for a newly created story.
     *
     * @param string $id
     */
    public function success($id)
    {
        $decodeID = base64_decode($id);

        $postIds = unserialize(
            request()
                ->cookie('post', serialize([])),
        );

        if (! in_array($decodeID, $postIds)) {
            return abort(404);
        }

        $post = Post::findBySlugOrID($decodeID);

        $category = Categories::all();
        $series   = Series::all();
        $tags     = Tag::all();

        return view('public.story.success', compact('post', 'category', 'series', 'tags'));
    }


    /**
     * Update the specified story in the storage.
     *
     * @param \App\Http\Requests\WriteNewStoryUpdateRequest $request 
     */
    public function update(WriteNewStoryUpdateRequest $request)
    {

        $postIds = unserialize(
            request()
                ->cookie('post', serialize([])),
        );

        if (! in_array($request->id, $postIds)) {
            return abort(404);
        }

        $post = Post::findOrFail($request->id);

        $post->name    = $request->name;
        $post->email   = $request->email;
        $post->content = ConvertPlaneTextToEditorJsBlocks($request->content);

        $this->updateTags($request->tags, $request->id);
        $this->updateCategories($request->category, $request->id);
        $this->updateSeries($request->series, $request->id);



        if ($request->hasFile('file')) {

            $fileController = new FileController;

            $thumbnail = $fileController->uploadFileToDatabase($request->file('file'));

            $id = $thumbnail->getOriginalContent()['File']->id;

            $this->updateThumbnail($id, $request->id);
        }


        $post->save();

        return redirect()
            ->back()
            ->withSuccess('আপনার গল্প আপডেট করা হয়েছে ');

    }


    /**
     * Update Post's Thumbnail
     */
    private function updateThumbnail($thumbnail, int $postID = null)
    {
        PostThumbnail::where('post_id', $postID)->delete();
        PostThumbnail::create([
            'post_id' => $postID,
            'file_id' => $thumbnail,
        ]);
    }

    /**
     * Update Post's Tags.
     **/
    private function updateTags($tags = null, int $postID = null)
    {
        if (empty($tags) && ! is_array($tags))
            return;

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
    private function updateCategories($categories = [], int $postID = null)
    {
        if (empty($categories) && ! is_array($categories))
            return;

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
    private function updateSeries($seriesID = null, int $postID = null)
    {
        if (empty($seriesID))
            return;

        PostSeries::where('post_id', $postID)->delete();

        PostSeries::create([
            'post_id'   => $postID,
            'series_id' => $seriesID,
        ]);
    }

}