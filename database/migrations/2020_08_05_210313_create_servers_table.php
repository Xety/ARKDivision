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
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->ipAddress('ip');
            $table->integer('rcon_port');
            $table->string('password', 50)->nullable();
            $table->string('color', 6)->nullable();
            $table->string('emoji', 50)->nullable();
            $table->unsignedInteger('user_count')->default(0);
            $table->bigInteger('discord_message_id')->unsigned();
            $table->boolean('is_display')->default(true);
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
        Schema::dropIfExists('servers');
    }
};
