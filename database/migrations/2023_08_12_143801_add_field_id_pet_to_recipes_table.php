<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIdPetToRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_recipes', function (Blueprint $table) {
            $table->integer('id_pet')->nullable()->default(0)->after('id_appointment');
        });
        Schema::table('reminders', function (Blueprint $table) {
            $table->integer('read')->nullable()->default(0)->after('id_pet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_recipes', function (Blueprint $table) {
            $table->dropColumn('id_pet');
        });
        Schema::table('reminders', function (Blueprint $table) {
            $table->dropColumn('read');
        });
    }
}
