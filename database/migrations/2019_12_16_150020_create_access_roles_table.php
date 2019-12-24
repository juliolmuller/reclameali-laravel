<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessRolesTable extends Migration
{
    public function up()
    {
        Schema::create('access_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 10);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('access_roles');
    }
}
