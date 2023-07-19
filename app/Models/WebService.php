<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebService extends Model
{
    use HasFactory;

    protected $casts = [
        'token' => 'json'
    ];

    protected $guarded = [];
}
