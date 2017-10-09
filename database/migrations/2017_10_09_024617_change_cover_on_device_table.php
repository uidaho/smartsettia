<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCoverOnDeviceTable extends Migration
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
            $table->dropColumn('cover_status');
            $table->dropColumn('cover_command');
        });
    
        Schema::table('devices', function(Blueprint $table)
        {
            $table->enum('cover_status', ['opening', 'closing', 'open', 'closed', 'locked', 'error'])->default('locked')->comment('The devices status as enum: opening, closing, open, closed, locked, error');
            $table->enum('cover_command', ['open', 'close', 'lock'])->default('lock')->comment('The commanded status as enum: open, close, lock');
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
            $table->dropColumn('cover_status');
            $table->dropColumn('cover_command');
        });
    
        Schema::table('devices', function(Blueprint $table)
        {
            $table->enum('cover_status', ['opening', 'closing', 'open', 'closed', 'locked', 'error'])->nullable()->comment('The devices status as enum: opening, closing, open, closed, locked, error');
            $table->enum('cover_command', ['open', 'close', 'lock'])->nullable()->comment('The commanded status as enum: open, close, lock');
        });
    }
}
