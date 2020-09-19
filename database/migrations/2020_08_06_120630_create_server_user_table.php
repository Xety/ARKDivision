<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('steam_id')->index();
            $table->integer('server_id')->unsigned()->index();
            $table->string('steam_name', 50)->nullable();
            $table->string('ingame_name', 50)->nullable();
            $table->string('tribe', 50)->nullable();
            $table->timestamps();
        });

        if (App::environment() !== 'testing') {
            Schema::table('server_user', function (Blueprint $table) {
                $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_user');
    }
}