<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_progresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('day');
            $table->unsignedSmallInteger('progress');
            $table->unsignedBigInteger('challenge_id');
            $table->timestamps();

            $table->foreign('challenge_id')->references('id')->on('challenges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenge_progresses');
    }
}
