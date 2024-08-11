<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\WriteNewStoryRequest;

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


        return view('public.story.success', compact('post', 'category'));
    }

}