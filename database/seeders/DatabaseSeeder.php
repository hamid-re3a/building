<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\UnitInvoice;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\UltraMsgService;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {



//        // User::factory(10)->create();
        foreach (Unit::query()->isResident()->get() as $unit){
//        $unit = Unit::find(24);
//            if($unit->water_debt > 0) {
                $amount = toPersianNumber($unit->charge_debt);
//                $string = <<< EOT
//            سلام سرکار خانم/جناب آقای {$unit->owner_name} وقتتون بخیر 🌷
//            قبض‌های مربوط به {$unit->name} به شرح زیر هست:
//
//            🔹 قبض آب: {$number} تومان
//
//
//            لطفاً در اسرع وقت نسبت به پرداخت اقدام فرمایید 🙏
//            در صورت پرداخت، لطفاً رسید را برای مدیریت ارسال فرمایید.
//            شماره حساب  حمیدرضا نوروزی نژاد: 6104337930371545
//
//            با تشکر
//            🔑 مدیریت ساختمان
//            EOT;


        $string = <<< EOT
سلام و احترام سرکار خانم/جناب آقای {$unit->owner_name} 🌷

ضمن تشکر بابت پرداخت قبض برق 🙏
مبلغ شارژ تا انتهای خرداد ماه مربوط به  {$unit->name} به شرح زیر است:

🔹 مبلغ شارژ ساختمان: {$amount} تومان

لطفاً محبت بفرمایید و مبلغ فوق را در اولین فرصت به شماره حساب زیر واریز نمایید:

شماره حساب : 6104337930371545
به نام : حمیدرضا نوروزی نژاد

در صورت پرداخت، لطفاً رسید را در همین چت ارسال فرمایید.

*خواهشمند است امروز تا پیش از ساعت ۱۲ ظهر، خودروی خود را به جهت نظافت از پارکینگ خارج فرمایید.*


با سپاس فراوان
🔑 مدیریت ساختمان
EOT;
//
                sendWhatsappMsg($unit->owner_number,$string);
            }
//        }



//        foreach(Unit::all() as $u) {
//            $per_unit = 192950;
//            UnitInvoice::create([
//                'unit_id' => $u->id,
//                'type' => 'آب',
//                'amount' => $u->number_of_residents * $per_unit,
//                'building_invoice_id' => 1
//            ]);
//        }

//        foreach(Unit::query()->isResident()->get() as $u) {
//            $per_unit = 250000;
//            UnitInvoice::create([
//                'unit_id' => $u->id,
//                'type' => 'شارژ',
//                'name' => 'شارژ خرداد ماه',
//                'amount' => $per_unit,
//            ]);
//        }
    }
}
