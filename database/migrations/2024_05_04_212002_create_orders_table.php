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
            $table->id();
            $table->dateTime('order_at');
            $table->dateTime('finished_at');
            $table->integer('grandtotal');
            $table->integer('grandtotalpoin');
            $table->dateTime('estimation');
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
