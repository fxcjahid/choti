<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
	/**
	 * Model for the resource.
	 *
	 * @var string
	 */
	protected $model = File::class;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'created_at',
		'updated_at',
	];


	public function index()
	{
		$table = File::orderBy('id', 'DESC')
			->with([
				'user:id,username',
			])
			->latest()
			->get(); 
			
		return response()->json($table);
	}
}