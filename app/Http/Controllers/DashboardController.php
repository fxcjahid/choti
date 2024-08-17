<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::getAll()
            ->when(true, function ($query) use ($request) {

                $orderType = $request->get('orderBy');

                if (! empty($orderType)) {
                    /**
                     * Order By 
                     */
                    switch ($orderType) {

                        case 'lastUpdate':
                            $query
                                ->where('updated_at', '>', now()->subDays(10)->endOfDay())
                                ->orderBy('updated_at', 'DESC');
                            break;

                        case 'name':
                            $query->orderBy('name');
                            break;

                        case 'asc':
                            $query->orderBy('id', 'ASC');
                            break;

                        case 'desc':
                            $query->orderBy('id', 'DESC');
                            break;

                        case 'views':
                            $query->orderByViews()->get();
                            break;

                        default:
                            $query->orderBy('id', 'DESC');
                            break;
                    }
                } else {
                    $query->orderBy('id', 'DESC');
                }
            })
            ->where(function ($query) use ($request) {

                $status = $request->get('status');

                if (! empty($status)) {
                    $query->where('status', '=', $status);
                }
            })
            ->paginate(25);  //get first 25 rows

        $statistics = Post::statistics();

        return view('admin.layout', compact('posts', 'statistics'));
    }
}