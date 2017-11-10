<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReAddLastNetworkUpdateAtToDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('last_network_update_at');
        });
        Schema::table('devices', function (Blueprint $table) {
            $table->timestamp('last_network_update_at')->useCurrent();
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
            $table->dropColumn('last_network_update_at');
        });
        Schema::table('devices', function (Blueprint $table) {
            $table->dateTime('last_network_update_at')->default(Carbon::now());
        });
    }
}
