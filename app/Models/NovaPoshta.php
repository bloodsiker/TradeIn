<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovaPoshta extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function requests()
    {
        return $this->belongsToMany(BuybackRequest::class, 'nova_poshta_requests', 'np_id', 'request_id');
    }
}
