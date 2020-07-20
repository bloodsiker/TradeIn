<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuybackRequestActForm extends Model
{
    public function request()
    {
        return $this->belongsTo(BuybackRequest::class);
    }
}
