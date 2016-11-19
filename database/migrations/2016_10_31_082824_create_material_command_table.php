<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialCommandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('material_command', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('command_id')->unsigned()->nullable(); ;
            $table->integer('material_id')->unsigned()->nullable(); ;
            $table->bigInteger('quantity')->default(0);
            $table->float('unite_price')->default(0);
            $table->float('mantant_facture')->default(0);
            $table->float('pret')->default(0);
            $table->float('taux_euro')->default(0);
            $table->float('euro_dinars')->default(0);
            $table->float('taux_dinars')->default(0);
            $table->float('taux_douane')->default(0);
            $table->float('transit_fees')->default(0);
            $table->float('taux_achat')->default(0);
            $table->float('calculed_price')->default(0);

            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
        
        Schema::table('material_command', function($table) {
            $table->foreign('command_id')->references('id')->on('commands');
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
        Schema::drop('material_command');
    }
}
