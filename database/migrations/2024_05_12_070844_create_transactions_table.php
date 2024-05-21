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
            $table->uuid('transaction_id')->primary();
            $table->string('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->double('gross_amount');
            $table->dateTime('transaction_time')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('status_message')->nullable();
            $table->integer('status_code')->nullable();
            $table->dateTime('settlement_time')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('fraud_status')->nullable();
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
