<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrafficLightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic_lights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_street_id');
            $table->foreignId('outgoing_street_id');
            $table->enum('status', [\App\Models\Control\TrafficLight::getAvailableStatus()])->default(\App\Models\Control\TrafficLight::CLOSED);
            $table->integer('default_switch_time');

            $table->foreign('incoming_street_id')->references('id')->on('streets');
            $table->foreign('outgoing_street_id')->references('id')->on('streets');
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
        Schema::dropIfExists('traffic_lights');
    }
}
