<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDefaultJobRateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->integer('update_rate')->default(4);
        });
        Schema::table('devices', function (Blueprint $table) {
            $table->integer('image_rate')->default(15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->integer('update_rate')->default(60);
        });
        Schema::table('devices', function (Blueprint $table) {
            $table->integer('image_rate')->default(60);
        });
    }
}
