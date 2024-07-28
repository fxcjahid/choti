<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::where('status', 'publish')
            ->with('thumbnail')
            ->orderByDesc('created_at')
            ->get()
            ->take(20);

        return view('public.home.index', compact('posts'));
    }
}