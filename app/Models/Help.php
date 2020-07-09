<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $attributes = [
        'is_active' => true,
    ];

    public function files()
    {
        return $this->hasMany(HelpFile::class);
    }
}
