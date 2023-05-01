<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->default(0);
            $table->string('user')->nullable();
            $table->string('role')->nullable();
            $table->text('activity')->nullable();
            $table->unsignedBigInteger('door_id')->default(0);
            $table->string('door')->nullable();
            $table->unsignedBigInteger('schedule_id')->default(0);
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
        Schema::dropIfExists('app_logs');
    }
}
