<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuybackRequest extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function model()
    {
        return $this->hasOne(DeviceModel::class, 'id', 'model_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
