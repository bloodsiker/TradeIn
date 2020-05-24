<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_ADMIN   = 1;
    const ROLE_NETWORK = 2;
    const ROLE_SHOP    = 3;
}
