<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run migration
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('status_id')->index();
            $table->unsignedBigInteger('type_id')->index();
            $table->timestamp('closed_at')->nullable();
            $table->userstamps(false);

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('status_id')
                ->references('id')
                ->on('ticket_status');

            $table->foreign('type_id')
                ->references('id')
                ->on('ticket_types');
        });
    }

    /**
     * Reverse migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
