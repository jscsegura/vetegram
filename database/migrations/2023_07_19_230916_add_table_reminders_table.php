<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('to', 255)->nullable();
            $table->text('description')->nullable();
            $table->datetime('date')->nullable();
            $table->integer('email')->default(0);
            $table->integer('sms')->default(0);
            $table->integer('whatsapp')->default(0);
            $table->integer('status')->default(0);
            $table->integer('attemps')->default(0);
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
        Schema::dropIfExists('reminders');
    }
}
