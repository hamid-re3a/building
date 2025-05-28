<?php
namespace App\Http\Controllers;


use App\Models\ParkingReservation;
use App\Models\Unit;
use App\Models\UnitInvoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $allPaidAmount = UnitInvoice::sum('paid_amount');


        $reservations = $this->getParkingReservations();


        $allUnits = Unit::with('invoices')->isResident()->get();
        return view('building', ['allPaidAmount' => $allPaidAmount, 'allUnits' => $allUnits, 'reservations' => $reservations]);
    }

    public function deposit(Request $request)
    {
        $unit = Unit::find($request->unit_id);
        $wallet = $unit->getUnitWallet($request->type);
        $wallet->deposit($request->amount);

        $unit->payInvoiceType($request->type);

        return redirect('/');
    }

    public function reserveParking(Request $request)
    {
        $request->validate([
            'spot' => 'required',
            'unit_id' => 'required',
            'date' => 'required',
            'password' => 'required',
        ]);

        $unit = Unit::find($request->unit_id);
        if($request->password != $unit->password){
            return redirect('/')->with('error', 'رمز اشتباه است.');
        }
        DB::beginTransaction();
        try{
            $invoice = UnitInvoice::create([
                'unit_id' => $unit->id,
                'type' => 'parking',
                'name' => 'رزرو پارکینگ ' . $request->date,
                'amount' => 50000,
            ]);

            ParkingReservation::create([
                'unit_id' => $unit->id,
                'unit_invoice_id' => $invoice->id,
                'reserved_date' => $request->date,
                'slot_number' => $request->spot,
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect('/')->with('error', 'عملیات با خطا مواجه شد.');

        }
        DB::commit();



        return redirect('/')->with('success', 'جای پارک برای شما رزرو شد لطفا بعد از واریز پول رسید خود را برای مدیریت ارسال کنید. با تشکر');
    }

    public function cancelParking(ParkingReservation $reservation)
    {

        // فقط ادمین اجازه حذف داشته باشه
        if (auth()->id() != 1) {
            return redirect('/')->with('error', 'عملیات با خطا مواجه شد.');
        }

        DB::beginTransaction();
        try{
            $reservation->unit_invoice()->delete();
            $reservation->delete();
            } catch(\Exception $e) {
                DB::rollBack();
                return redirect('/')->with('error', 'عملیات با خطا مواجه شد.');

            }
        DB::commit();
        return back()->with('success', 'رزرو با موفقیت حذف شد.');
    }
    public function invoice(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required',
            'unit_id' => 'required',
            'type' => 'required',
            'spot' => 'nullable',
            'from_date' => 'required_if:type,parking|date',
            'to_date' => 'required_if:type,parking|date|after:from_date',
        ]);


        if($request->type = 'parking'){

            $amount = abs($request->amount);
            $from_date = Carbon::create($request->from_date);
            $to_date = Carbon::create($request->to_date);

            $per_day_amount = $amount / ($from_date->diffInDays($to_date) +1);



            while($from_date->isBefore($to_date) || $from_date->isSameDay($to_date)){
                $invoice = UnitInvoice::create([
                    'unit_id' => $request->unit_id,
                    'type' => 'parking',
                    'name' => 'رزرو پارکینگ ' . $from_date,
                    'amount' => $per_day_amount,
                ]);

                ParkingReservation::create([
                    'unit_id' => $request->unit_id,
                    'unit_invoice_id' => $invoice->id,
                    'reserved_date' => $from_date,
                    'slot_number' => $request->spot,
                ]);

                $from_date->addDay();
            }


        } else if($request->unit_id = 'building'){
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
        return redirect('/')->with('success', 'رزرو با موفقیت حذف شد.');
    }

    /**
     * @return array
     */
    public function getParkingReservations(): array
    {
        $reservations = [];

        $startDate = Carbon::today();

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->toDateString(); // 'Y-m-d'

            $reservations[$date] = [
                1 => null,
                2 => null,
            ];

            $dayReservations = ParkingReservation::with('unit')
                ->where('reserved_date', $date)
                ->get();

            foreach ($dayReservations as $res) {
                $reservations[$date][$res->slot_number] = $res ?? '---';
            }
        }


        return $reservations;
    }
}
