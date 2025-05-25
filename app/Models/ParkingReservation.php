<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingReservation extends Model
{
    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function unit_invoice()
    {
        return $this->belongsTo(UnitInvoice::class);
    }
}
