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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('claimed_coffre_count_total')->default(0)->after('color_remain');
            $table->unsignedInteger('claimed_coffre_count_monthly')->default(0)->after('claimed_coffre_count_total');
            $table->dateTime('last_claimed_coffre')->nullable()->after('claimed_coffre_count_monthly');
        });
    }
};
