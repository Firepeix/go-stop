<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_id');
            $table->string('name');
            $table->string('uuid');
            $table->json('outgoing_streets')->nullable();
            $table->json('outgoing_traffic_lights')->nullable();
            $table->float('graph_position_x', 255, 12);
            $table->float('graph_position_y', 255, 12);
            $table->foreign('sample_id')->references('id')->on('samples');
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
        Schema::dropIfExists('streets');
    }
}
