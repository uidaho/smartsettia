<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveLimitSwitchesFromDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('limitsw_open');
            $table->dropColumn('limitsw_closed');
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
            $table->boolean('limitsw_open')->nullable()->comment('Should be 1 when unit is in open position according to the limit switch.');
            $table->boolean('limitsw_closed')->nullable()->comment('Should be 1 when unit is in closed position accoring to the limit switch.');
        });
    }
}
