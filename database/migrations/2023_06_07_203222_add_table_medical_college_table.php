<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableMedicalCollegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_colleges', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('dni', 100)->nullable();
            $table->string('category', 255)->nullable();
            $table->string('enabled', 255)->nullable();
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
        Schema::dropIfExists('medical_colleges');
    }
}
