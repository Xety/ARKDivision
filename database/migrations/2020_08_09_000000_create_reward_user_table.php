<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('reward_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->boolean('was_used')->default(false);
            $table->timestamps();
        });

        /**
         * Only create foreign key on production/development.
         */
        if (App::environment() !== 'testing') {
            Schema::table('reward_user', function (Blueprint $table) {
                $table->foreign('reward_id')->references('id')->on('rewards')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('reward_user');
    }
}
