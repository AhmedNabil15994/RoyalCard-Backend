<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {


            $table->unsignedBigInteger("product_id");
            $table->foreign('product_id')
                                ->references('id')->on('products')
                                ->onUpdated("cascade")
                                ->onDelete('cascade');


            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')
                                ->references('id')->on('users')
                                ->onUpdated("cascade")
                                ->onDelete('cascade');
            $table->primary(["product_id", "user_id"]);
            $table->integer('rate')->default(0);
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
        Schema::dropIfExists('ratings');
    }
}
