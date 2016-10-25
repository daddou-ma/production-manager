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
            $table->integer('material_id')->unsigned()->nullable(); ;
            $table->bigInteger('quantity')->default(0);
            $table->bigInteger('progress')->default(0);
            $table->boolean('state')->default(false);

            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::table('commands', function($table) {
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('material_id')->references('id')->on('materials');
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
