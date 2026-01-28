<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAnimalBreedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_breeds', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default('0')->nullable();
            $table->string('title_es', 255)->nullable();
            $table->string('title_en', 255)->nullable();
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
        Schema::dropIfExists('animal_breeds');
    }
}
