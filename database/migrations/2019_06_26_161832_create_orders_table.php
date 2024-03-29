<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_checked')->default(False);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('status_id')->unsigned()->default(1);
            $table->decimal('sum', 12, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('orders', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('order_statuses');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
