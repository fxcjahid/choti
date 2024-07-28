<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WriteNewStoryController extends Controller
{
    public function index()
    {
        return view("public.story.index");
    }
}