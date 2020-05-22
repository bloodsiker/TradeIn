<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function network()
    {
        return $this->hasOne(Network::class, 'id', 'network_id');
    }
}
