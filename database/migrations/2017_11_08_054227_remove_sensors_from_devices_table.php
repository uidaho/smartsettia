<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSensorsFromDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('light_in');
            $table->dropColumn('light_out');
            $table->dropColumn('cpu_temp');
            $table->dropColumn('temperature');
            $table->dropColumn('humidity');
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
            $table->float('light_in', 4, 1)->nullable()->comment('Value of light sensor inside awning. 0.0 to 100.0 %');
            $table->float('light_out', 4, 1)->nullable()->comment('Value of light sensor outside awning. 0.0 to 100.0 %');
            $table->float('cpu_temp', 5, 2)->nullable()->comment('Device processor temperature in 000.00 C');
            $table->float('temperature', 5, 2)->nullable()->comment('Temperature sensor in 000.00 C');
            $table->float('humidity', 4, 1)->nullable()->comment('Humidity sensor in 0.0 to 100.0 %');
        });
    }
}
