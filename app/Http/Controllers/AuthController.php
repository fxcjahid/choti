<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HasCrudActions;

class AuthController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'auth.auth';

    /**
     * Route prefix.
     *
     * @var string
     */
    protected $routePrefix = 'public.auth';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'public.auth';

}