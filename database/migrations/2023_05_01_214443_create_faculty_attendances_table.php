<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_attendances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->default(0);
            $table->string('rfid')->nullable();
            $table->string('user_name')->nullable();
            $table->string('role')->nullable();
            $table->unsignedBigInteger('door_id')->default(0);
            $table->unsignedBigInteger('schedule_id')->default(0);
            $table->date('attendance_date')->nullable();
            $table->string('log_type')->nullable();
            

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
        Schema::dropIfExists('faculty_attendances');
    }
}
