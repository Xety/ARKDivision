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
            $table->unsignedInteger('claimed_coffre_bonus_5_count_total')->default(0)
                            ->after('claimed_coffre_count_total');

            $table->unsignedInteger('claimed_coffre_bonus_10_count_total')->default(0)
                            ->after('claimed_coffre_bonus_5_count_total');

            $table->unsignedInteger('claimed_coffre_bonus_15_count_total')->default(0)
                            ->after('claimed_coffre_bonus_10_count_total');

            $table->unsignedInteger('claimed_coffre_bonus_20_count_total')->default(0)
                            ->after('claimed_coffre_bonus_15_count_total');

            $table->unsignedInteger('claimed_coffre_bonus_25_count_total')->default(0)
                            ->after('claimed_coffre_bonus_20_count_total');

            $table->unsignedInteger('claimed_coffre_bonus_30_count_total')->default(0)
                            ->after('claimed_coffre_bonus_25_count_total');
        });
    }
};
