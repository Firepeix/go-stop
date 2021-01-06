<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreetConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('street_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_street_id');
            $table->foreignId('child_street_id');
            $table->foreign('parent_street_id')->references('id')->on('streets');
            $table->foreign('child_street_id')->references('id')->on('streets');
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
        Schema::dropIfExists('street_connections');
    }
}
