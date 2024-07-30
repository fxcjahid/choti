<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\HasCrudActions;
use Illuminate\Http\Request;

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

}