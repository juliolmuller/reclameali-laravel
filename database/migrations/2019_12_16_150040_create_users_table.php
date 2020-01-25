<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 30);
            $table->string('last_name', 150);
            $table->char('cpf', 11)->unique()->index();
            $table->date('date_of_birth');
            $table->string('phone', 16)->nullable();
            $table->string('email')->unique()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('street')->nullable();
            $table->integer('number')->nullable();
            $table->char('zip_code', 8)->nullable();
            $table->string('complement', 20)->nullable();
            $table->string('city', 64)->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('role_id');
            $table->string('password');
            $table->rememberToken();
            $table->changesTracking();
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('role_id')->references('id')->on('access_roles');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
