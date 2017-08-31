<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedules', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('type')->unsigned();                        # 0 = open, 1 = close
			$table->integer('time')->unsigned();                        # Military time example: 7pm -> 1900
			$table->integer('device_id')->unsigned();
			
			$table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('schedules');
	}
}
