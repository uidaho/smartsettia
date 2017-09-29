<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatesToDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->integer('update_rate')->default(60)->comment('Interval the device posts config data in seconds.');
            $table->integer('image_rate')->default(60)->comment('Interval the device posts image data in seconds.');
            $table->integer('sensor_rate')->default(60)->comment('Interval the device posts sensor data in seconds.');
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
            $table->dropColumn([ 'update_rate', 'image_rate', 'sensor_rate' ]);
        });
    }
}
