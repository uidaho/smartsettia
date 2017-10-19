<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ReCreateSensorDataTable extends Migration {

	public function up()
	{
		Schema::drop('sensor_data');
		Schema::create('sensor_data', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('sensor_id')->unsigned();
			$table->string('value');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('sensor_data');
		Schema::create('sensor_data', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('sensor_id')->unsigned();
			$table->string('value');
			$table->timestamp('created_at')->useCurrent();
			$table->foreign('sensor_id')->references('id')->on('sensors')->onDelete('cascade');
		});
	}
}