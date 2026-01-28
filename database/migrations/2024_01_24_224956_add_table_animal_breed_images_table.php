<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAnimalBreedImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_breed_images', function (Blueprint $table) {
            $table->id();
            $table->integer('id_breed')->nullable();
            $table->string('title_es', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('enabled')->default(0);
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
        Schema::dropIfExists('animal_breed_images');
    }
}
