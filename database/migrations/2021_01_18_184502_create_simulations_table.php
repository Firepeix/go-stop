<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulations', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_quantity');
            $table->foreignId('sample_id');
            $table->integer('min_second_interval');
            $table->integer('max_second_interval');
            $table->json('result')->nullable();
    
            $table->foreign('sample_id')->references('id')->on('street_samples');
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
        Schema::dropIfExists('simulations');
    }
}
