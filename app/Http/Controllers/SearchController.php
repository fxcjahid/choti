<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Request query
     */
    public function show(Request $request)
    {
        $searchKeyword = $request->keyword;

        $post = Post::select(['id', 'name', 'slug'])
            ->where('name', 'like', "%{$searchKeyword}%")
            ->orWhere('slug', 'like', "%{$searchKeyword}%")
            ->with([
                'category:id,slug,name'
            ])
            ->get();

        $post = collect($post);

        return response()->json([
            'results' => $post->count(),
            'post' => $post,
        ]);
    }
}
