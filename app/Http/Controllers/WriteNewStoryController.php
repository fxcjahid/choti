<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Series;
use App\Models\PostTags;
use App\Models\Categories;
use App\Models\PostSeries;
use Illuminate\Http\Request;
use App\Models\PostThumbnail;
use App\Models\PostCategories;
use App\Traits\HasCrudActions;
use Illuminate\Support\Facades\Storage;
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


    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('public.account.create-story');
        }

        return view('public.story.index');
    }

    /**
     * Store a newly created resource in storage.
     * 
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


        $post->name  = $request->name;
        $post->email = $request->email;

        $this->updateTags($request->tags, $request->id);
        $this->updateCategories($request->category, $request->id);
        $this->updateSeries($request->series, $request->id);



        if ($request->hasFile('file')) {
            dd($request->file('file'));
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