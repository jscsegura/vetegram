<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsAppointmenClientPhysicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_clients', function (Blueprint $table) {
            $table->string('symptoms', 255)->nullable()->after('diagnosis');
            $table->string('history', 255)->nullable()->after('symptoms');
            $table->text('physical')->nullable()->after('history');
            $table->string('differential', 255)->nullable()->after('physical');
            $table->string('differential_other', 255)->nullable()->after('differential');
            $table->string('definitive', 255)->nullable()->after('differential_other');
            $table->string('definitive_other', 255)->nullable()->after('definitive');
            $table->text('treatment')->nullable()->after('definitive_other');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_clients', function (Blueprint $table) {
            $table->dropColumn('symptoms');
            $table->dropColumn('history');
            $table->dropColumn('physical');
            $table->dropColumn('differential');
            $table->dropColumn('differential_other');
            $table->dropColumn('definitive');
            $table->dropColumn('definitive_other');
            $table->dropColumn('treatment');
        });
    }
}
