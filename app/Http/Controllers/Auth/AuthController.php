<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Responds to requests to GET Login Page
     */
    public function getLogin()
    {
        /**
         * Redirect to Dashboard if user already Logged In
         */
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Responds to requests to POST Login Credentials
     */
    public function postLogin(Request $request)
    {

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {

            // Add this for security
            $request->session()->regenerate();

            return redirect()
                ->intended(route('admin.dashboard'))
                ->withSuccess('Signed in');
        }

        return Redirect::back()->withErrors(['error' => 'Invaild email & password']);
    }


    public function customRegistration(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data  = $request->all();
        $check = $this->create($data);

        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('admin.login');
    }
}

