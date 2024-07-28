<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	use HasFactory;

	protected $table = 'company'; // Set database table name

	public $timestamps = false; // Disable update_at, create_at
}
