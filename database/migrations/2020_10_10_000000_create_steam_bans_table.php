<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSteamBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steam_bans', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger('steam_id');
            $table->bigInteger('banned_by')->nullable();
            $table->boolean('forever')->default(false);
            $table->text('reason');
            $table->dateTime('expire_at')->nullable();
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
        Schema::dropIfExists('steam_bans');
    }
}
