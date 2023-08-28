<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billed_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('payer_id');
            $table->string('payer_email');
            $table->string('address_name');
            $table->string('address_street');
            $table->string('address_zip');
            $table->string('address_country_code');
            $table->string('quantity');
            $table->string('transaction_id');
            $table->bigInteger('payment_gross');
            $table->dateTime('payment_date');
            $table->string('currency_code');
            $table->string('invoice_id');
            $table->dateTime('billed_date');
            $table->string('reservation_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billed_reservations');
    }
};
