<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAccessRolesTable extends Migration
{
    /**
     * Run migration
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_roles', function (Blueprint $table) {
            $table->userstamps(false);
        });
    }

    /**
     * Reverse migration
     *
     * @return void
     */
    public function down()
    {
        Schema::table('access_roles', function (Blueprint $table) {
            $table->dropUserstamps(false);
        });
    }
}
