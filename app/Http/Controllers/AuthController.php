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

    public function signup(RegisterNewUser $request)
    {
        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        /** Get cookie stored posts */
        $postIds = unserialize(
            request()
                ->cookie('post', serialize([])),
        );

        foreach ($postIds as $postId) {

            $post = Post::find($postId);

            if ($post) {
                $post->user_id = $user->id;
                $post->save();
            }
        }

        return redirect()->route('public.auth.index', ['tab' => 'login'])
            ->withSuccess(trans('attributes.success_signup'));
    }

    /**
     * Responds to requests to POST Login Credentials
     */
    public function login(Request $request)
    {

        $request->validate([
            'email'                => 'required',
            'password'             => 'required',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('login_action')],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->back()
                ->withSuccess('Signed in');
        }

        return Redirect::back()
            ->withErrors(['error' => trans('attributes.invaild_email_password')]);
    }
}