<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['city', 'state_id']);
            $table->bigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }
}
