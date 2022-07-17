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
        Schema::create('order_fillings', function (Blueprint $table) {
            $table->id('pkId');
            $table->unsignedInteger('orderId')->references('pkId')->on('orders');
            $table->unsignedInteger('fillingId')->references('pkId')->on('filligs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
