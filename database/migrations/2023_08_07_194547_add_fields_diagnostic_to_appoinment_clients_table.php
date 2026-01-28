<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsDiagnosticToAppoinmentClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_clients', function (Blueprint $table) {
            $table->text('diagnosis')->nullable()->after('reason');
        });
        Schema::table('reminders', function (Blueprint $table) {
            $table->integer('id_user')->nullable()->default(0)->after('id');
            $table->integer('id_pet')->nullable()->default(0)->after('id_appointment');
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
            $table->dropColumn('diagnosis');
        });
        Schema::table('reminders', function (Blueprint $table) {
            $table->dropColumn('id_user');
            $table->dropColumn('id_pet');
        });
    }
}
