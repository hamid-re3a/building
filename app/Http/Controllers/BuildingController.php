<?php
namespace App\Http\Controllers;


use App\Models\Unit;
use App\Models\UnitInvoice;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $allPaidAmount = UnitInvoice::sum('paid_amount');

        $allUnits = Unit::with('invoices')->isResident()->get();
        return view('building', ['allPaidAmount' => $allPaidAmount, 'allUnits' => $allUnits]);
    }

    public function deposit(Request $request)
    {
        $unit = Unit::find($request->unit_id);
        $wallet = $unit->getUnitWallet($request->type);
        $wallet->deposit($request->amount);

        $unit->payInvoiceType($request->type);

        return redirect('/');
    }


    public function invoice(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required',
            'unit_id' => 'required',
            'type' => 'required',
        ]);

        if($request->unit_id = 'building'){
            UnitInvoice::create([
                'type' => $request->type,
                'name' => $request->name,
                'amount' => -1 *  abs($request->amount),
                'paid_amount' => -1 *  abs($request->amount),
            ]);
        }
//        $unit = Unit::find($request->unit_id);
//        $wallet = $unit->getUnitWallet($request->type);
//        $wallet->deposit($request->amount);
//
//        $unit->payInvoiceType($request->type);
//
        return redirect('/');
    }
}
