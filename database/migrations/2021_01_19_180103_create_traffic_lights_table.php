<?php

use App\Models\Control\TrafficLight;
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
            $table->string('uuid');
            $table->string('name');
            $table->foreignId('sample_id');
            $table->json('outgoingStreets')->nullable();
            $table->float('upperBoundX', 255, 12);
            $table->float('upperBoundY', 255, 12);
            $table->float('lowerBoundX', 255, 12);
            $table->float('lowerBoundY', 255, 12);
            $table->enum('status', [TrafficLight::getAvailableStatus()])->default(TrafficLight::CLOSED);
            $table->integer('default_switch_time');
            $table->timestamps();
    
            $table->foreign('sample_id')->references('id')->on('samples');
    
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
