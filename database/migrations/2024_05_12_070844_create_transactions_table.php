<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->integer('gross_amount');
            $table->dateTime('transaction_time');
            $table->enum('transaction_status', ['pending', 'settlement', 'expire']);
            $table->string('status_message');
            $table->integer('status_code');
            $table->dateTime('settlement_time');
            $table->string('payment_type');
            $table->boolean('fraud_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
