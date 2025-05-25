<?php

namespace App\Models;

use Bavix\Wallet\Traits\CanConfirm;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Model;
use Bavix\Wallet\Traits\HasWallets;
use Illuminate\Support\Str;

class Unit extends Model implements \Bavix\Wallet\Interfaces\Wallet
{
    use HasWallet, HasWallets, CanConfirm;

    public function invoices()
    {
        return $this->hasMany(UnitInvoice::class);
    }

    public function getWaterDebtAttribute()
    {
        $allWaterBillsAmount = $this->invoices()->where('type','water')->sum('amount');
        $allWaterBillsPaidAmount = $this->invoices()->where('type','water')->sum('paid_amount');
        $debt =(int) ($allWaterBillsPaidAmount - $allWaterBillsAmount);
        if($debt > 0) {
            return 0;
        } else
        return abs($debt);
    }

    public function getUnitWallet($wallet_name)
    {
        $wallet_name = strtoupper($wallet_name);
        $slug = Str::slug($wallet_name);
        $wallet = $this->getWallet($slug);
        if (!$wallet) {
            $wallet = $this->createWallet([
                'name' => $wallet_name,
                'slug' => $slug
            ]);
        }
        return $wallet;

    }

    public function unitBalance()
    {
        return $this->getUnitWallet('charge')->balance +$this->getUnitWallet('water')->balance;
    }


    public function getChargeDebtAttribute()
    {
        $allWaterBillsAmount = $this->invoices()->where('type','charge')->sum('amount');
        $allWaterBillsPaidAmount = $this->invoices()->where('type','charge')->sum('paid_amount');
        $debt =(int) ($allWaterBillsPaidAmount - $allWaterBillsAmount);
        if($debt > 0) {
            return 0;
        } else
            return abs($debt);
    }



    public function getParkingDebtAttribute()
    {
        $allWaterBillsAmount = $this->invoices()->where('type','parking')->sum('amount');
        $allWaterBillsPaidAmount = $this->invoices()->where('type','parking')->sum('paid_amount');
        $debt =(int) ($allWaterBillsPaidAmount - $allWaterBillsAmount);
        if($debt > 0) {
            return 0;
        } else
            return abs($debt);
    }

    public function scopeIsResident($query)
    {
        return $query->where('is_resident',true);
    }


    public function payAllInvoices()
    {
        foreach(['water','charge','parking'] as $type){
            $this->payInvoiceType($type);
        }
    }


    public function payInvoiceType(string $type)
    {
        $wallet = $this->getUnitWallet($type);

        $unpaidInvoices = UnitInvoice::query()
            ->where('unit_id', $this->id)
            ->whereColumn('paid_amount', '<', 'amount')
            ->where('type', $type)
            ->oldest()
            ->get();

        foreach ($unpaidInvoices as $invoice) {
            $invoiceRemaining = $invoice->amount - $invoice->paid_amount;
            if ($wallet->balance >= $invoiceRemaining) {
                $wallet->withdraw($invoiceRemaining);
                $invoice->status = 'paid';
                $invoice->paid_amount = $invoice->amount;
                $invoice->save();
            } else {
                $invoice->paid_amount = $wallet->balance;
                $wallet->withdraw($wallet->balance);
                $invoice->status = 'partially_paid';
                $invoice->save();
                break;
            }
        }
    }
}
