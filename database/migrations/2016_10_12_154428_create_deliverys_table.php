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
            $table->boolean('state')->default(false);
            $table->integer('count_products')->default(0);
            $table->date('delivery_date');
            $table->float('total_notax')->default(0);
            $table->integer('taux_douane')->default(0);
            $table->integer('total_price')->default(0);
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
