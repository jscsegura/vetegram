<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAppointmentAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_attachments', function (Blueprint $table) {
            $table->id();
            $table->integer('id_appointment')->nullable();
            $table->integer('id_pet')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('folder', 255)->nullable();
            $table->string('attach', 255)->nullable();
            $table->double('size', 12, 2)->nullable();
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
        Schema::dropIfExists('appointment_attachments');
    }
}
