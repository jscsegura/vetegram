<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTablePhysicalCategoryUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_category_users', function (Blueprint $table) {
            $table->id();
            $table->integer('id_vet')->nullable()->default(0);
            $table->integer('id_category')->nullable()->default(0);
            $table->string('options', 255)->nullable()->default('');
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
        Schema::dropIfExists('physical_category_users');
    }
}
