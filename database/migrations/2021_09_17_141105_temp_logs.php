<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TempLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->string('telegram_id');
            $table->string('user_agent');
            $table->string('form_name');
            $table->string('user_ip');
            $table->string('country')->nullable();
            $table->string('country_img')->nullable();
            $table->string('token')->nullable();
            $table->text('main_dates');

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
        //
    }
}
