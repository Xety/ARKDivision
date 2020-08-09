<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statutes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('type', 20);
            $table->string('type_formatted', 50)->nullable();
            $table->text('description');
            $table->string('color', 7)->nullable();
            $table->string('emoji', 50)->nullable();
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
        Schema::dropIfExists('statutes');
    }
}
