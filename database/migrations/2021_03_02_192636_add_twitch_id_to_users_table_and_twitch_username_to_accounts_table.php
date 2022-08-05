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
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('twitch_username', 50)->nullable()->after('steam_username');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('twitch_id')->nullable()->after('steam_id');
            $table->boolean('twitch_abuse')->default(false)->after('twitch_id');
        });
    }
};
