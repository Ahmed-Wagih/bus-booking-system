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
        Schema::create('city_trip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedBigInteger('from_city');
            $table->foreign('from_city')->references('id')->on('cities')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedBigInteger('to_city');
            $table->foreign('to_city')->references('id')->on('cities')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('city_trip');
    }
};
