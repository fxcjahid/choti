<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Http\Controllers\Controller;


class UsersController extends Controller
{
    public function index()
    {
        $users = User::withCount('post as post')
            ->orderByDesc('created_at')
            ->paginate(10);

        $totalUser = User::count();

        return view('admin.views.users.index', compact('users', 'totalUser'));
    }

    public function store()
    {
        return 'store';
    }
}
