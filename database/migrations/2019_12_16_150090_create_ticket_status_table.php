<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketStatusTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 30);
            $table->string('description')->nullable();
            $table->changesTracking();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_status');
    }
}
