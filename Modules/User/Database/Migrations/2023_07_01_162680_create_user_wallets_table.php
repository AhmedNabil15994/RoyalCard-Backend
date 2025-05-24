<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("country_id");
            $table->foreign('country_id')
                                ->references('id')->on('countries')
                                ->onUpdated("cascade")
                                ->onDelete('cascade');
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')
                                ->references('id')->on('users')
                                ->onUpdated("cascade")
                                ->onDelete('cascade');
            $table->double('balance')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('user_wallets');
    }
}
