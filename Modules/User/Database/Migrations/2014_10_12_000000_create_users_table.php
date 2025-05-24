<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('calling_code')->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->string('code_verified')->unique();
            $table->string('email')->nullable();
            $table->timestamp('verification_expire_at')->nullable();
            $table->string('password');
            $table->integer('status');
            $table->integer('two_factor')->default(0);
            $table->integer('otp_verified')->default(0);
            $table->text('google_2fa')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
