<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIntervalVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vaccines', function (Blueprint $table) {
            $table->integer('section')->nullable()->default(0)->comment('0:vacunas, 1:desparasitaciones')->after('id');
            $table->integer('interval')->nullable()->default(0)->after('photo');
            $table->date('next_date')->nullable()->after('interval');
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
            $table->dropColumn('section');
            $table->dropColumn('interval');
            $table->dropColumn('next_date');
        });
    }
}
