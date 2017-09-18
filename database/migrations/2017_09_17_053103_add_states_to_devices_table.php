<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatesToDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable()->comment('A Version 1 UUID is a universally unique identifier that is generated using the MAC address of the computer on which it was generated.');
            $table->string('token', 60)->unique()->nullable()->comment('The devices api token.');
            $table->string('version', 32)->nullable()->comment('Semantic versioning string of the device. http://semver.org/');
            $table->string('hostname', 255)->nullable()->comment('The /etc/hostname of the device.');
            $table->ipAddress('ip')->nullable()->comment('The IPv4 address of the device.');
            $table->macAddress('mac_address')->nullable()->comment('The MAC address of the device.');
            $table->dateTime('time')->nullable()->comment('The GMT time from the devices clock. YYYY-MM-DD HH:MM:SS');
            $table->integer('timezone')->default(-8)->comment('The devices timezone UTF offset. -12 to +12');
            $table->enum('cover_status', ['opening', 'closing', 'open', 'closed', 'locked', 'error'])->nullable()->comment('The devices status as enum: opening, closing, open, closed, locked, error');
            $table->enum('cover_command', ['open', 'close', 'lock'])->nullable()->comment('The commanded status as enum: open, close, lock');
            $table->text('error_msg')->nullable()->comment('String description of the error, empty if none.');
            $table->boolean('limitsw_open')->nullable()->comment('Should be 1 when unit is in open position according to the limit switch.');
            $table->boolean('limitsw_closed')->nullable()->comment('Should be 1 when unit is in closed position accoring to the limit switch.');
            $table->time('open_time')->default('08:00:00')->comment('The time the device should open HH:MM:SS');
            $table->time('close_time')->default('17:00:00')->comment('The time the device should close HH:MM:SS');
            $table->integer('update_time')->default(60)->comment('The interval between the the next time the device posts data in seconds.');
            // TEMPORARY: these will get moved to sensors table
            $table->float('light_in', 4, 1)->nullable()->comment('Value of light sensor inside awning. 0.0 to 100.0 %');
            $table->float('light_out', 4, 1)->nullable()->comment('Value of light sensor outside awning. 0.0 to 100.0 %');
            $table->float('cpu_temp', 5, 2)->nullable()->comment('Device processor temperature in 000.00 C');
            $table->float('temperature', 5, 2)->nullable()->comment('Temperature sensor in 000.00 C');
            $table->float('humidity', 4, 1)->nullable()->comment('Humidity sensor in 0.0 to 100.0 %');
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
            $table->dropColumn([ 'uuid', 'token', 'version', 'hostname', 'ip', 
                'mac_address', 'time', 'timezone', 'cover_status', 'cover_command', 
                'error_msg', 'limitsw_open', 'limitsw_closed', 'open_time', 
                'close_time', 'update_time', 'light_in', 'light_out', 'cpu_temp',
                'temperature', 'humidity'
            ]);
        });
    }
}
