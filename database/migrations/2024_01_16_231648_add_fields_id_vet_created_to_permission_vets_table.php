<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsIdVetCreatedToPermissionVetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_attachments', function (Blueprint $table) {
            $table->integer('id_vet_created')->nullable()->default(0)->after('created_by');
        });

        Schema::table('appointment_notes', function (Blueprint $table) {
            $table->integer('id_vet_created')->nullable()->default(0)->after('created_by');
        });

        Schema::table('appointment_recipes', function (Blueprint $table) {
            $table->integer('id_vet_created')->nullable()->default(0)->after('created_by');
        });

        Schema::table('vaccines', function (Blueprint $table) {
            $table->integer('id_vet_created')->nullable()->default(0)->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_attachments', function (Blueprint $table) {
            $table->dropColumn('id_vet_created');
        });

        Schema::table('appointment_notes', function (Blueprint $table) {
            $table->dropColumn('id_vet_created');
        });

        Schema::table('appointment_recipes', function (Blueprint $table) {
            $table->dropColumn('id_vet_created');
        });

        Schema::table('vaccines', function (Blueprint $table) {
            $table->dropColumn('id_vet_created');
        });
    }
}
