<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use CyrildeWit\EloquentViewable\Support\Period;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Date ranges
        $currentWeekRange = [
            now()->subDays(6)->startOfDay(),
            now()->endOfDay(),
        ];

        $previousWeekRange = [
            now()->subDays(13)->startOfDay(),
            now()->subDays(7)->endOfDay(),
        ];

        // Current week stats
        $currentWeekVisitors = views(Post::class)->period(Period::pastWeeks(1))->remember()->count();
        $currentWeekPosts    = Post::whereBetween('created_at', $currentWeekRange)->count();
        $currentWeekUsers    = User::whereBetween('created_at', $currentWeekRange)->count();

        // Previous week stats
        $previousWeekVisitors = views(Post::class)->period(Period::create($previousWeekRange[0], $previousWeekRange[1]))->remember()->count();
        $previousWeekPosts    = Post::whereBetween('created_at', $previousWeekRange)->count();
        $previousWeekUsers    = User::whereBetween('created_at', $previousWeekRange)->count();

        // Calculate percentage changes
        $visitorsPercentChange = $previousWeekVisitors > 0
            ? (($currentWeekVisitors - $previousWeekVisitors) / $previousWeekVisitors) * 100
            : 0;

        $postsPercentChange = $previousWeekPosts > 0
            ? (($currentWeekPosts - $previousWeekPosts) / $previousWeekPosts) * 100
            : 0;

        $usersPercentChange = $previousWeekUsers > 0
            ? (($currentWeekUsers - $previousWeekUsers) / $previousWeekUsers) * 100
            : 0;

        $topPosts = Post::orderByViews('desc', Period::pastWeeks(1))
            ->take(10)
            ->get()
            ->map(function ($post) {
                return (object) [
                    'name'  => $post->title,
                    'url'   => $post->url(),
                    'views' => views($post)->count(),
                ];
            });


        return view('admin.views.dashboard.index', compact(
            'currentWeekVisitors',
            'currentWeekPosts',
            'currentWeekUsers',
            'visitorsPercentChange',
            'postsPercentChange',
            'usersPercentChange',
            'topPosts',
        ));
    }
}
