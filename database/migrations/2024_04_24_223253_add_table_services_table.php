<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_es', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->text('description_es')->nullable();
            $table->text('description_en')->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('enabled')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title_es', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->string('description_es', 255)->nullable();
            $table->string('description_en', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('enabled')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('about_mains', function (Blueprint $table) {
            $table->id();
            $table->string('title_es', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->text('description_es')->nullable();
            $table->text('description_en')->nullable();
            $table->string('image', 255)->nullable();
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
        Schema::dropIfExists('services');
        Schema::dropIfExists('abouts');
        Schema::dropIfExists('about_mains');
    }
}
