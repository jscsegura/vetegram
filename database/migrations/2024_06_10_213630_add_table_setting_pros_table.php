<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableSettingProsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_pros', function (Blueprint $table) {
            $table->id();
            $table->string('title_es', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->integer('pro')->nullable()->default(0);
            $table->integer('enabled')->nullable()->default(0);
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
        Schema::dropIfExists('setting_pros');
    }
}
