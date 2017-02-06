<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pagese extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagese', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('porosi_id')->unsigned();
            $table->string('transaction_id');
            $table->float('vlera');
            $table->timestamps();
            $table->foreign('porosi_id')->references('id')->on('porosi');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagese');
    }
}
