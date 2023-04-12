<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_students', function (Blueprint $table) {
            $table->id('attendance_student_id');

            $table->unsignedBigInteger('attendance_id');
            $table->foreign('attendance_id')->references('attendance_id')->on('attendances')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('student_id')->nullable();
            $table->string('student_lname')->nullable();
            $table->string('student_fname')->nullable();
            $table->string('student_mname')->nullable();
            $table->string('student_suffix')->nullable();
            $table->string('student_sex')->nullable();
            $table->string('student_contact_no')->nullable();

            $table->string('remark')->nullable();

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
        Schema::dropIfExists('attendance_students');
    }
}
