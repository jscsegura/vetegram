<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDoctorNameToVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vaccines', function (Blueprint $table) {
            $table->string('doctor_name', 255)->nullable()->after('id_doctor');
            $table->string('doctor_code', 255)->nullable()->after('doctor_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vaccines', function (Blueprint $table) {
            $table->dropColumn('doctor_name');
            $table->dropColumn('doctor_code');
        });
    }
}
