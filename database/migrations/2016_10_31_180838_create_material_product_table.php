<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('material_product', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable(); ;
            $table->integer('material_id')->unsigned()->nullable(); ;
            $table->bigInteger('quantity')->default(0);
            
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
        
        Schema::table('material_product', function($table) {
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::drop('material_product');
    }
}
