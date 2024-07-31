<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Request query
     */
    public function show(Request $request)
    {
        $searchKeyword = $request->keyword;

        $post = Post::select(['id', 'title', 'slug'])
            ->where('title', 'like', "%{$searchKeyword}%")
            ->orWhere('slug', 'like', "%{$searchKeyword}%")
            ->with([
                'category:id,slug,name',
            ])
            ->get();

        $post = collect($post);

        return response()->json([
            'results' => $post->count(),
            'post'    => $post,
        ]);
    }
}