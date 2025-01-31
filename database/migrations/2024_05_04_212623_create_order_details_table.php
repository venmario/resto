<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->string('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreignId('product_id')->constrained();
            $table->integer('price');
            $table->integer('poin');
            $table->integer('quantity');
            $table->string('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details', function (Blueprint $table) {
            $table->dropForeign('order_id');
            $table->dropForeign('product_id');
        });
    }
}
