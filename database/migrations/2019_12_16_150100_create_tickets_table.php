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
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('type_id')->unsigned();
            $table->bigInteger('status_id')->unsigned();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
