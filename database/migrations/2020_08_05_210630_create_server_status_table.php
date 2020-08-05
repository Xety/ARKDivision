<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id')->unsigned()->index();
            $table->integer('status_id')->unsigned()->index();
            $table->enum('event_type', ['discord', 'cron']);
            $table->boolean('was_forced')->default(false);
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
        });

        if (App::environment() !== 'testing') {
            Schema::table('server_status', function (Blueprint $table) {
                $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
                $table->foreign('status_id')->references('id')->on('statutes')->onDelete('cascade');
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
        Schema::dropIfExists('server_status');
    }
}
