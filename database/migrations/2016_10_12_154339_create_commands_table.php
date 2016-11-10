<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('commands', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->unsigned()->nullable(); ;
            $table->boolean('state')->default(false);
            $table->integer('count_materials')->default(0);
            $table->date('command_date');
            $table->integer('total_price')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::table('commands', function($table) {
            $table->foreign('provider_id')->references('id')->on('providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('commands');
    }
}
