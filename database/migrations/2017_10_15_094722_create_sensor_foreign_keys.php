<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateSensorForeignKeys extends Migration {

	public function up()
	{
		Schema::table('sensors', function(Blueprint $table) {
			$table->foreign('device_id')->references('id')->on('devices')
						->onDelete('cascade');
		});
		Schema::table('sensor_data', function(Blueprint $table) {
			$table->foreign('sensor_id')->references('id')->on('sensors')
						->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::table('sensors', function(Blueprint $table) {
			$table->dropForeign('sensors_device_id_foreign');
		});
		Schema::table('sensor_data', function(Blueprint $table) {
			$table->dropForeign('sensor_data_sensor_id_foreign');
		});
	}
}