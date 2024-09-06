<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFungsisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fungsi', function (Blueprint $table) {
            $table->id('fungsi_id',200);
            $table->unsignedBigInteger('unit_id');
            $table->string('fungsi_name',300);
            $table->timestamps();

            
            $table->foreign('unit_id')->references('unit_id')->on('unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fungsi');
    }
}
