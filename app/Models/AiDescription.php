<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiDescription extends Model
{
    use HasFactory;

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
        'heading',
        'description',
        'status',
    ];
}
