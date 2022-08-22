<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('seat_id');
            $table->unsignedBigInteger('trip_id');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedBigInteger('city_trip_id');
            $table->foreign('city_trip_id')->references('id')->on('city_trip')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('reservations');
    }
};
