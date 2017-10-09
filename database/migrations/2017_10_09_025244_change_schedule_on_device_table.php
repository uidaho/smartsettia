<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeScheduleOnDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function(Blueprint $table)
        {
            $table->dropColumn('open_time');
            $table->dropColumn('close_time');
        });
        
        Schema::table('devices', function(Blueprint $table)
        {
            $table->time('open_time')->default('15:00:00')->comment('The time the device should open HH:MM:SS');
            $table->time('close_time')->default('24:00:00')->comment('The time the device should close HH:MM:SS');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices', function(Blueprint $table)
        {
            $table->dropColumn('open_time');
            $table->dropColumn('close_time');
        });
        
        Schema::table('devices', function(Blueprint $table)
        {
            $table->time('open_time')->default('08:00:00')->comment('The time the device should open HH:MM:SS');
            $table->time('close_time')->default('17:00:00')->comment('The time the device should close HH:MM:SS');
        });
    }
}
