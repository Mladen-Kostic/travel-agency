<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('travel_insurances_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->foreign('travel_insurances_id')->references('id')->on('travel_insurances');
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
        Schema::dropIfExists('group_insurances');
    }
}
