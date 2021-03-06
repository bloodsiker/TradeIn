<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovaPoshta extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function packet()
    {
        return $this->hasOne(BuybackPacket::class, 'id', 'packet_id');
    }
}
