<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
	public function view()
	{
		$region = City::all()->groupBy('region');

		return view('public.page.service.coverage', compact('region'));
	}
}
