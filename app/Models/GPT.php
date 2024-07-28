<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPT extends Model
{
    use HasFactory;

    protected $table = 'gpt'; // Set database table name

    public $timestamps = false; // Disable update_at, create_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_code',
        'city_slug',
        'service',
        'description',
        'status',
        'comment'
    ];
}