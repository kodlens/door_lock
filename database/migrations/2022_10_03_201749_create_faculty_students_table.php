<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_students', function (Blueprint $table) {
            $table->id('faculty_student_id');
            $table->string('student_id')->nullable();

            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id')->references('faculty_id')->on('faculty')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('student_lname')->nullable();
            $table->string('student_fname')->nullable();
            $table->string('student_mname')->nullable();
            $table->string('student_suffix')->nullable();
            $table->string('student_sex')->nullable();
            $table->string('student_contact_no')->nullable();


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
        Schema::dropIfExists('faculty_students');
    }
}
