<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAppointmentClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_clients', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->nullable();
            $table->integer('id_pet')->nullable();
            $table->integer('id_owner')->nullable();
            $table->integer('id_hours')->nullable();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->string('reason', 255)->nullable();
            $table->integer('status')->nullable()->comment('0: pending, 1: progress, 2: finish, 3: cancel');
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
        Schema::dropIfExists('appointment_clients');
    }
}
