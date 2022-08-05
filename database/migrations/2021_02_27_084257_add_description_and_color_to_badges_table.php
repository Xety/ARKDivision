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
        Schema::table('badges', function (Blueprint $table) {
            $table->renameColumn('image', 'icon');
        });

        Schema::table('badges', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->string('description')->nullable()->after('slug');
            $table->string('color', 7)->nullable()->after('icon');
        });
    }
};
