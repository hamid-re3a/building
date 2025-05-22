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
        Schema::create('units', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name');
            $table->integer('number_of_residents')->default(1);
            $table->string('owner_name')->nullable();
            $table->string('owner_number')->nullable();
            $table->timestamps();
        });
        Schema::create('building_invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('type')->default('water');
            $table->decimal('amount',16,2);
            $table->timestamps();
        });
        Schema::create('unit_invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('unit_id');
            $table->string('type')->default('water');
            $table->string('status')->default('not_paid');
            $table->decimal('amount',16,2);
            $table->decimal('paid_amount',16,2)->default(0);
            $table->foreignId('building_invoice_id')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
