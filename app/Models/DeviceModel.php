<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}
