<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDateOtherToVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vaccines', function (Blueprint $table) {
            $table->date('date')->nullable()->after('name');
            $table->string('brand', 255)->nullable()->after('date');
            $table->string('batch', 255)->nullable()->after('brand');
            $table->date('expire')->nullable()->after('batch');
            $table->string('photo', 255)->nullable()->after('expire');
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
            $table->dropColumn('date');
            $table->dropColumn('brand');
            $table->dropColumn('batch');
            $table->dropColumn('expire');
            $table->dropColumn('photo');
        });
    }
}
