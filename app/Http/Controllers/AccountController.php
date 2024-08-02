<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterNewUser;
use Illuminate\Support\Facades\Redirect;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class AccountController extends Controller
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
    protected $label = 'account.account';

    /**
     * Route prefix.
     *
     * @var string
     */
    protected $routePrefix = 'public.account';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'public.account';

    public function index()
    {
        return view('public.account.page.profile');
    }

    public function posts()
    {
        $posts = Post::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('public.account.page.posts', compact('posts'));
    }

}