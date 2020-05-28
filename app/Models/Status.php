<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const STATUS_NEW    = 1;
    const STATUS_SENT_  = 2;
    const STATUS_TAKE_  = 3;
    const STATUS_RETURN = 4;
}
