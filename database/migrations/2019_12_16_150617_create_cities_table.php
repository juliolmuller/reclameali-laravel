<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('name', 80);
            $table->integer('state_id');
            $table->timestamps();
            $table->primary('id');
            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
