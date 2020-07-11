<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technic extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name'
    ];
}
