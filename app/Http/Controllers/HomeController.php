<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Show the homepage content. 
     */
    public function index()
    {
        $posts = Post::where('status', 'publish')
            ->with('thumbnail')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('public.home.index', compact('posts'));
    }
}