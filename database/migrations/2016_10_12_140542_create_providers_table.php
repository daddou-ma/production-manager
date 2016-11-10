<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('providers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('nrc');
            $table->string('nif');
            $table->string('na');
            $table->string('address');
            $table->string('phone');
            $table->string('fax');
            $table->integer('count_commands')->default(0);

            $table->boolean('actif')->default(true);
            $table->timestamps();
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
        Schema::drop('providers');
    }
}
