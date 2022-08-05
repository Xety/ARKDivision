<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger('discord_id')->unique();
            $table->unsignedInteger('ticket_count')->default(0);
            $table->unsignedInteger('ticket_opened')->default(0);
            $table->bigInteger('ticket_message_id')->nullable();
            $table->dateTime('last_ticket_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
