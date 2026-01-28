<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAppointmentHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_hours', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->nullable();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->integer('status')->nullable()->comment('0: available, 1: reserve, 2: lock');
            $table->datetime('expire')->nullable();
            $table->integer('user_reserve')->default(0)->nullable();
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
        Schema::dropIfExists('appointment_hours');
    }
}
