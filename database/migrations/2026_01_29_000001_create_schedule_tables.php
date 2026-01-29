<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->index();
            $table->string('description', 255)->nullable();
            $table->string('status', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('schedule_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_schedule')->index();
            $table->string('day_of_week', 20)->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('status', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('schedule_extra_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_schedule')->index();
            $table->string('description', 255)->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('schedule_exceptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_schedule')->index();
            $table->string('description', 255)->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('reason')->nullable();
            $table->boolean('is_all_day')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('schedule_configurations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_schedule')->index();
            $table->integer('min_time_from_today')->nullable();
            $table->integer('max_time_from_today')->nullable();
            $table->integer('time_between_slots')->nullable();
            $table->integer('time_before_appointment')->nullable();
            $table->integer('time_after_appointment')->nullable();
            $table->integer('procedure_break_time')->nullable();
            $table->integer('daily_appointment_limit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_configurations');
        Schema::dropIfExists('schedule_exceptions');
        Schema::dropIfExists('schedule_extra_slots');
        Schema::dropIfExists('schedule_details');
        Schema::dropIfExists('schedule');
    }
}
