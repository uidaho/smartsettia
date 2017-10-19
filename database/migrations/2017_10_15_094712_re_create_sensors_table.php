<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ReCreateSensorsTable extends Migration {

	public function up()
	{
		Schema::drop('sensors');
		Schema::create('sensors', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('device_id')->unsigned();
			$table->string('name')->index()->default('New Sensor');
			$table->string('type')->index();
		});
	}

	public function down()
	{
		Schema::drop('sensors');
		Schema::create('sensors', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('device_id')->unsigned();
			$table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
		});
	}
}