<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderToRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->boolean('gender')->default(false)->after('image');
            $table->string('gender_male')->nullable()->after('gender');
            $table->string('gender_female')->nullable()->after('gender_male');
        });
    }
}
