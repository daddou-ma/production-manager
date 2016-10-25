<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('fabrications', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable(); ;
            $table->integer('client_id')->unsigned()->nullable(); ;
            $table->bigInteger('quantity')->default(0);

            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::table('fabrications', function($table) {
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::drop('fabrications');
    }
}
