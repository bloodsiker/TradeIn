<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    protected $fillable = [
        'brand_id', 'name', 'price', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $attributes = [
        'is_deleted' => false,
    ];

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function technic()
    {
        return $this->hasOne(Technic::class, 'id', 'technic_id');
    }
}
