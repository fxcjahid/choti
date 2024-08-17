<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Butschster\Head\Facades\Meta;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategorydController extends Controller
{
    public function index()
    {
        $categoryCount = Categories::count();

        return view('admin.views.category', compact('categoryCount'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Categories::updateOrCreate($request->all());

        if ($category) {
            return response()->json([
                'success' => true,
                'data'    => $category,
                'message' => 'The category was created.',
            ]);
        }
    }

    public function update(UpdateCategoryRequest $request)
    {
        $category = Categories::find($request->id);

        // Update column
        $category->name        = $request->name;
        $category->slug        = $request->slug;
        $category->is_active   = $request->is_active;
        $category->description = $request->description;

        if ($category->save()) {
            return response()->json([
                'success' => true,
                'message' => 'The category was update.',
            ]);
        }
    }

    public function show()
    {
        $category = Categories::withCount('post as post')
            ->orderBy('name')
            ->get();

        return response()->json($category);
    }

    /**
     * Get post by category wise
     */
    public function postByCategory($category)
    {
        $category = Categories::with([
            'post' => function ($query) {
                $query->where('status', '=', 'publish');
            },
        ])
            ->where(
                [
                    ['slug', '=', $category],
                    ['is_active', '=', true],
                ],
            )
            ->orWhere(
                [
                    ['id', '=', $category],
                    ['is_active', '=', true],
                ],
            )
            ->when(Auth()->check(), function ($query) use ($category) {
                $query
                    ->where([
                        ['slug', '=', $category],
                        ['is_active', '=', true],
                    ])
                    ->orWhere([
                        ['slug', '=', $category],
                        ['is_active', '=', false],
                    ]);
            })
            ->firstOrFail();

        /**
         * Set Pagination for Post
         */
        $category->setRelation(
            'post',
            $category
                ->post()
                ->with('thumbnail')
                ->orderByDesc('created_at')
                ->paginate(10),
        );

        /**
         * Make Hide useless arrtibutes
         */
        $category->post->each(function ($each) {
            return $each->makeHidden([
                'user_id',
                'summary',
                'status',
                'readTime',
                'pivot',
                'content',
                'created_at',
                'updated_at',
                'deleted_at',
                'body',
            ]);
        });

        $categorylist = Categories::where('is_active', true)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        Meta::setTitle($category->name)
            ->setPaginationLinks($category->post)
            ->setCanonical(request()->url());


        return view('public.category.show', compact('category', 'categorylist'));
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        $destroy = Categories::destroy($id);

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