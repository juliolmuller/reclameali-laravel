<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('type_id')->index();
            $table->unsignedBigInteger('status_id')->index();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('type_id')->references('id')->on('ticket_types');
            $table->foreign('status_id')->references('id')->on('ticket_status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
