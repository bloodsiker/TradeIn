<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceModelRequest extends Model
{
    const NOT_COMPLETED = 0;
    const COMPLETED     = 1;

    protected $attributes = [
        'is_done' => self::NOT_COMPLETED,
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function attributeStatus($attribute)
    {
        if ($attribute === 'text') {
            return $this->is_done ? 'Выполнена' : 'Не выполнена';
        } elseif ($attribute === 'color') {
            return $this->is_done ? 'success' : 'danger';
        }
        return null;
    }
}
