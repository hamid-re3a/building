<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parking_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('unit_invoice_id');
            $table->date('reserved_date');
            $table->unsignedTinyInteger('slot_number'); // چون گفتی دو جای پارک، این می‌تونه 1 یا 2 باشه
            $table->timestamps();

            $table->unique(['reserved_date', 'slot_number']); // هر جای پارک فقط یک رزرو در روز
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_reservations');
    }
};
