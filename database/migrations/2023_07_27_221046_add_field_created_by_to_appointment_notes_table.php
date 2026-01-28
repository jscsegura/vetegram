<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCreatedByToAppointmentNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_notes', function (Blueprint $table) {
            $table->integer('created_by')->nullable()->after('note');
        });

        Schema::table('appointment_attachments', function (Blueprint $table) {
            $table->integer('created_by')->nullable()->after('size');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_notes', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });

        Schema::table('appointment_attachments', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
}
