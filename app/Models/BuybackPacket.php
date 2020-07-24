<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuybackPacket extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function ttn()
    {
        return $this->hasOne(NovaPoshta::class, 'packet_id', 'id');
    }

    public function requests()
    {
        return $this->belongsToMany(BuybackRequest::class, 'buyback_packet_request', 'packet_id', 'request_id');
    }
}
