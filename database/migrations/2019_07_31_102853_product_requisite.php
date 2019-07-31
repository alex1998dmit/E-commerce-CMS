<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductRequisite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_requisite')) {
            Schema::create('product_requisite', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id')->unsigned();
                $table->bigInteger('requisite_id')->unsigned();
                $table->timestamps();
            });

            Schema::table('product_requisite', function($table) {
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('requisite_id')->references('id')->on('requisites');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_requisite');
    }
}
