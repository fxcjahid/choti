<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
	use HasFactory;

	/** 
	 * Disable Time column
	 * **/
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'post_id',
		'tag_id'
	];
}