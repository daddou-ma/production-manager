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
            $table->bigInteger('progress')->default(0);
            $table->bigInteger('quantity')->default(0);
            $table->bigInteger('embalage')->default(0);
            $table->bigInteger('sac')->default(0);
            $table->date('fabrication_date');

            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::table('fabrications', function($table) {
            $table->foreign('product_id')->references('id')->on('products');
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
