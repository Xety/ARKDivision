<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('username', 20)->unique()->index();
            $table->string('email', 50)->unique()->index();
            $table->string('password')->nullable();
            $table->string('slug', 20)->unique();
            $table->bigInteger('discord_id')->nullable()->unique();
            $table->bigInteger('steam_id')->nullable()->unique();
            $table->string('api_token', 80)->unique()->nullable();
            $table->unsignedInteger('discuss_conversation_count')->default(0);
            $table->unsignedInteger('discuss_post_count')->default(0);
            $table->unsignedInteger('experiences_total')->default(0);
            $table->unsignedInteger('rubies_total')->default(0);
            $table->unsignedInteger('reward_count')->default(0);
            $table->unsignedInteger('transaction_count')->default(0);
            $table->unsignedInteger('skin_count')->default(0);
            $table->unsignedInteger('skin_remain')->default(0);
            $table->unsignedInteger('color_count')->default(0);
            $table->unsignedInteger('color_remain')->default(0);
            $table->boolean('ticket_opened')->default(false);
            $table->bigInteger('ticket_message_id')->nullable();
            $table->rememberToken();
            $table->ipAddress('register_ip');
            $table->ipAddress('last_login_ip')->nullable();
            $table->dateTime('skin_asked_at')->nullable();
            $table->dateTime('color_asked_at')->nullable();
            $table->dateTime('ticket_asked_at')->nullable();
            $table->dateTime('member_expire_at')->nullable();
            $table->dateTime('last_login')->nullable();
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
        Schema::dropIfExists('users');
    }
}
