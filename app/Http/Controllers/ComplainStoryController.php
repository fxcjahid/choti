<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Complain;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use App\Http\Requests\StoreComplainRequest;

class ComplainStoryController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Complain::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'complain.complain';

    /**
     * Route prefix.
     *
     * @var string
     */
    protected $routePrefix = 'complain';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'public.complain';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = StoreComplainRequest::class;
}