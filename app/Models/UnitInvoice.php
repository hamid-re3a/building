<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitInvoice extends Model
{
    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
