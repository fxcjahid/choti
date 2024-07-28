<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Rolandstarke\Thumbnail\Thumbnail;

class File extends Model
{
	use HasFactory;

	protected $table = 'files';

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * The attributes that should be visible in serialization.
	 *
	 * @var array
	 */
	protected $visible = ['id', 'filename', 'user', 'create', 'created_at', 'path', 'small', 'medium'];

	/**
	 * The attributes that should be hide in serialization.
	 *
	 * @var array
	 */
	protected $hidden = [];


	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime:Y-m-d',
		'deleted_at' => 'datetime:Y-m-d h:i:s'
	];

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['create'];

	public function getCreateAttribute()
	{
		return $this->created_at->diffForHumans();
	}

	/**
	 * Get the file's path.
	 *
	 * @param string $path
	 * @return string|null
	 */
	public function getPathAttribute($path)
	{
		if (!is_null($path)) {
			return Storage::disk($this->disk)->url($path);
		}
	}

	public function getSmallAttribute($small)
	{
		if (!is_null($small)) {

			return Storage::disk($this->disk)->url($small);
		} else {

			return $this->path;
		}
	}

	public function getMediumAttribute($medium)
	{
		if (!is_null($medium)) {
			return Storage::disk($this->disk)->url($medium);
		} else {

			return $this->path;
		}
	}

	/**
	 * Get post Creator
	 * Relation between table
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}


	/**
	 * Determine if the file type is image.
	 *
	 * @return bool
	 */
	public function isImage()
	{
		return strtok($this->mime, '/') === 'image';
	}
}