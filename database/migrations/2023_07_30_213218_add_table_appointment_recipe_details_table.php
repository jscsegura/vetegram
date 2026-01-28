<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAppointmentRecipeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_recipe_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_recipe')->nullable()->default(0);
            $table->integer('id_medicine')->nullable()->default(0);
            $table->string('title', 255)->nullable();
            $table->string('duration', 255)->nullable();
            $table->integer('id_take')->nullable()->default(0);
            $table->string('take', 255)->nullable();
            $table->string('quantity', 255)->nullable();
            $table->text('instruction')->nullable();
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
        Schema::dropIfExists('appointment_recipe_details');
    }
}
