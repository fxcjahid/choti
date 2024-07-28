<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComplainStoryController extends Controller
{
    public function index()
    {
        return view("public.complain.index");
    }
}