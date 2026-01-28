<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableVetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vets', function (Blueprint $table) {
            $table->id();
            $table->integer('country')->nullable();
            $table->string('code', 50)->nullable();
            $table->string('social_name', 255)->nullable();
            $table->string('company', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('province', 255)->nullable();
            $table->string('canton', 255)->nullable();
            $table->string('district', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('specialities', 255)->nullable();
            $table->string('languages', 255)->nullable();
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
        Schema::dropIfExists('vets');
    }
}
