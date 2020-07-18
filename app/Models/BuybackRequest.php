<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuybackRequest extends Model
{
    protected $attributes = [
        'is_deleted' => false,
        'status_id' => Status::STATUS_NEW,
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function paidBy()
    {
        return $this->hasOne(User::class, 'id', 'paid_by');
    }

    public function model()
    {
        return $this->hasOne(DeviceModel::class, 'id', 'model_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function ttn()
    {
        return $this->belongsToMany(NovaPoshta::class);
    }
}
