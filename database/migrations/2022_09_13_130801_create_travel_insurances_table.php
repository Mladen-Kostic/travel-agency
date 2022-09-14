<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('insurance_types_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('dob');
            $table->dateTime('departure');
            $table->dateTime('return');
            $table->string('from');
            $table->string('to');
            $table->string('vacation_length');
            $table->foreign('insurance_types_id')->references('id')->on('insurance_types');
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
        Schema::dropIfExists('travel_insurances');
    }
}
