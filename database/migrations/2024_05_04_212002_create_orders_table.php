<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->dateTime('order_at');
            $table->dateTime('finished_at')->nullable();
            $table->string('order_status')->default('waiting payment');
            $table->dateTime('booked_at')->nullable();
            $table->string('snap_token')->nullable();
            $table->integer('grandtotal')->nullable();
            $table->integer('grandtotalpoin')->nullable();
            $table->dateTime('estimation')->nullable();
            // $table->enum('type', ['dine in', 'pick up']);
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('orders', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
}
