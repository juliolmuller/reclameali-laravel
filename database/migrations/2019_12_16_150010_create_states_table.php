<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name', 19)->index();
            $table->char('abreviation', 2)->index();
            $table->timestamps();
            $table->primary('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('states');
    }
}
