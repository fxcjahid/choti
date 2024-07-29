<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeriesRequest;
use App\Http\Requests\UpdateSeriesRequest;
use App\Models\Series;

class SeriesController extends Controller
{
    public function index()
    {
        $seriesCount = Series::count();

        return view('admin.views.series', compact('seriesCount'));
    }

    public function store(StoreSeriesRequest $request)
    {
        $Series = Series::updateOrCreate($request->all());

        if ($Series) {
            return response()->json([
                'success' => true,
                'data'    => $Series,
                'message' => 'The Series was created.',
            ]);
        }
    }

    public function update(UpdateSeriesRequest $request)
    {
        $Series = Series::find($request->id);

        // Update column
        $Series->name        = $request->name;
        $Series->slug        = $request->slug;
        $Series->is_active   = $request->is_active;
        $Series->description = $request->description;

        if ($Series->save()) {
            return response()->json([
                'success' => true,
                'message' => 'The Series was update.',
            ]);
        }
    }

    public function show()
    {
        $Series = Series::withCount('post as post')
            ->orderBy('name')
            ->get();

        return response()->json($Series);
    }

    /**
     * Get post by Series wise
     */
    public function postBySeries($series)
    {
        $series = Series::with([
            'post' => function ($query) {
                $query->where('status', '=', 'publish');
            },
        ])
            ->where(
                [
                    ['slug', '=', $series],
                    ['is_active', '=', true],
                ],
            )
            ->orWhere(
                [
                    ['id', '=', $series],
                    ['is_active', '=', true],
                ],
            )
            ->when(Auth()->check(), function ($query) use ($series) {
                $query
                    ->where([
                        ['slug', '=', $series],
                        ['is_active', '=', true],
                    ])
                    ->orWhere([
                        ['slug', '=', $series],
                        ['is_active', '=', false],
                    ]);
            })
            ->firstOrFail();

        /**
         * Set Pagination for Post
         */
        $series->setRelation(
            'post',
            $series
                ->post()
                ->with('thumbnail')
                ->paginate(200),
        );

        /**
         * Make Hide useless arrtibutes
         */
        $series->post->each(function ($each) {
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


        return view('public.series.show', compact('series'));
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        $destroy = Series::destroy($id);

        if ($destroy) {
            return response()->json([
                'status'  => 1,
                'message' => 'The Series was deleted.',
            ]);
        } else {
            return response()->json([
                'status'  => 0,
                'message' => 'fail',
            ]);
        }
    }
}