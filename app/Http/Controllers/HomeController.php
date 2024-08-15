<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Categories;
use Butschster\Head\Facades\Meta;

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

        $category = Categories::where('is_active', '=', true)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        Meta::setTitle(__('app.name'))
            ->setPaginationLinks($posts)
            ->setCanonical(request()->url());

        return view('public.home.index', compact('posts', 'category'));
    }
}