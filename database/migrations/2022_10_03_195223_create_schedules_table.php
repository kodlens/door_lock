<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('schedule_id');

            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id')->references('faculty_id')->on('faculty')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('door_id');
            $table->foreign('door_id')->references('door_id')->on('doors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('ay_id');
            $table->foreign('ay_id')->references('ay_id')->on('academic_years')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            

            $table->time('time_start');
            $table->time('time_end');

            $table->tinyInteger('mon');
            $table->tinyInteger('tue');
            $table->tinyInteger('wed');
            $table->tinyInteger('thu');
            $table->tinyInteger('fri');
            $table->tinyInteger('sat');
            $table->tinyInteger('sun');

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
        Schema::dropIfExists('schedules');
    }
}
