<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovaPoshtaCounterpartyPerson extends Model
{
    protected $table = 'nova_poshta_counterparty_persons';

    public function counterparty()
    {
        return $this->belongsTo(NovaPoshtaCounterparty::class, 'id', 'counterparty_id');
    }
}
