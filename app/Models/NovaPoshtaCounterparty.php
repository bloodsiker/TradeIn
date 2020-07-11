<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovaPoshtaCounterparty extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function person()
    {
        return $this->hasMany(NovaPoshtaCounterpartyPerson::class);
    }

    public function fullName()
    {
        return $this->first_name .' ' . $this->middle_name .' ' .$this->last_name;
    }
}
