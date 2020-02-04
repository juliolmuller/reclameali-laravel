<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run migration
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->nullable()->unique();
            $table->string('controller');
            $table->string('method', 100);
            $table->userstamps(false);

            $table->unique(['controller', 'method']);
        });
    }

    /**
     * Reverse migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
