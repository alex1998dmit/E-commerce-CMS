<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('wish_lists')) {
            Schema::create('wish_lists', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id')->unsigned();
                $table->bigInteger('product_id')->unsigned();
                $table->timestamps();
            });
        }

        Schema::table('wish_lists', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wish_lists');
    }
}
