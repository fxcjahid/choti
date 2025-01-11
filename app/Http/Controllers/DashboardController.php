<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use CyrildeWit\EloquentViewable\Support\Period;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $postViews = views('App\Models\Post')->period(Period::pastWeeks(1))->remember()->count();
        return view('admin.views.dashboard.index', compact('postViews'));
    }
}