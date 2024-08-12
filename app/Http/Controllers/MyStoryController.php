<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Series;
use App\Models\Categories;
use App\Http\Requests\StoreSeriesRequest;
use App\Http\Requests\UpdateSeriesRequest;

class MyStoryController extends Controller
{
    public function index()
    {
        $postIds = unserialize(
            request()
                ->cookie('post', serialize([])),
        );

        $posts = Post::whereIn('id', $postIds)
            ->paginate(10);

        return view('public.story.mystory', compact('posts'));
    }


    public function edit($id)
    {
        $decodeID = base64_decode($id);

        $postIds = unserialize(
            request()
                ->cookie('post', serialize([])),
        );

        if (! in_array($decodeID, $postIds) && ! auth()->check()) {
            return abort(404);
        }

        $post = Post::findBySlugOrID($decodeID);

        $category = Categories::all();
        $series   = Series::all();
        $tags     = Tag::all();

        return view('public.story.edit', compact('post', 'category', 'series', 'tags'));
    }
}