<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->json('prices');
            $table->integer('qty');
            $table->string('product_type');
            $table->string('international_code')->nullable();
            $table->string('sku')->nullable();
            $table->json('shipment')->nullable();
            $table->json('codes')->nullable();
            $table->json('available_servers')->nullable();
            $table->boolean('status')->default(false);
            $table->integer('user_max_uses')->default(1);
            $table->integer('order')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
