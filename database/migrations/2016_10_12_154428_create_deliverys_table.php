<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('deliveries', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->nullable(); ;
            $table->bigInteger('quantity')->default(0);
            $table->bigInteger('progress')->default(0);
            $table->boolean('state')->default(false);

            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::table('deliveries', function($table) {
            $table->foreign('client_id')->references('id')->on('clients');
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
        Schema::drop('deliveries');
    }
}
