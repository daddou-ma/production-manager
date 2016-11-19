<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('product_delivery', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_id')->unsigned()->nullable(); ;
            $table->integer('product_id')->unsigned()->nullable(); ;
            $table->bigInteger('quantity')->default(0);
            $table->float('unite_price')->default(0);
            $table->float('price')->default(0);

            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
        
        Schema::table('product_delivery', function($table) {
            $table->foreign('delivery_id')->references('id')->on('deliveries');
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
        Schema::drop('product_delivery');
    }
}
