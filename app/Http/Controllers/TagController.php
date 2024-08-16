<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Categories;
use Illuminate\Http\Request;
use Butschster\Head\Facades\Meta;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    public function index()
    {
        $tagCount = Tag::count();

        return view('admin.views.tag', compact('tagCount'));
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::updateOrCreate($request->all());

        if ($tag) {
            return response()->json([
                'success' => true,
                'tag'     => $tag,
                'message' => 'The tag was created.',
            ]);
        }
    }

    /**
     * Update exiting tags
     */
    public function update(UpdateTagRequest $request)
    {
        $tag = Tag::find($request->id);

        // Update column
        $tag->name        = $request->name;
        $tag->slug        = $request->slug;
        $tag->is_active   = $request->is_active;
        $tag->description = $request->description;

        if ($tag->save()) {
            return response()->json([
                'success' => true,
                'message' => 'The tag was update.',
            ]);
        }
    }

    public function show()
    {
        $tag = Tag::withCount('post as post')
            ->orderBy('name')
            ->get();

        return response()->json($tag);
    }

    /**
     * Get post by tag wise
     */
    public function postBytag($tag)
    {
        $tag = Tag::with([
            'post' => function ($query) {
                return $query->where('status', '=', 'publish')
                    ->with(
                        'thumbnail',
                    );
            },
        ])
            ->where(
                [
                    ['slug', '=', $tag],
                    ['is_active', '=', true],
                ],
            )
            ->when(! Auth()->check(), function ($query) {
                return $query->where([
                    ['slug', '!=', 'guide'],
                    ['slug', '!=', 'popular'],
                    ['slug', '!=', 'suggestion'],
                ]);
            })
            ->orWhere(
                [
                    ['id', '=', $tag],
                    ['is_active', '=', true],
                ],
            )
            ->firstOrFail();

        /**
         * Set Pagination for Post
         */
        $tag->setRelation('post',
            $tag
                ->post()
                ->with('thumbnail')
                ->paginate(42),
        );



        $taglist = Categories::where('is_active', true)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        Meta::setTitle($tag->name)
            ->setPaginationLinks($tag->post)
            ->setCanonical(request()->url());

        return view('public.category.show', compact('tag', 'taglist'));
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        $destroy = Tag::destroy($id);

        if ($destroy) {
            return response()->json([
                'status'  => 1,
                'message' => 'The category was deleted.',
            ]);
        } else {
            return response()->json([
                'status'  => 0,
                'message' => 'fail',
            ]);
        }
    }
}