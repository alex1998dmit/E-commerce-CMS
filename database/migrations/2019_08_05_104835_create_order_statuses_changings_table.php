<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusesChangingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses_changings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('prev_status_id')->unsigned();
            $table->bigInteger('new_status_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('order_statuses_changings', function($table) {
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('prev_status_id')->references('id')->on('order_statuses');
            $table->foreign('new_status_id')->references('id')->on('order_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_statuses_changings');
    }
}
