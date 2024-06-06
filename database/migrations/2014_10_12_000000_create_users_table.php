<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('id_telegram')->unique();
            $table->string('name_telegram');
            $table->string('api')->nullable();
            $table->string('first_name_telegram')->nullable();
            $table->string('photo_telegram')->nullable();
            $table->boolean('confirm_status')->nullable();
            $table->boolean('balance')->default(0);
            $table->string('payment_desc')->nullable();
            $table->dateTime('last_time_online')->nullable();
            $table->rememberToken();
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
