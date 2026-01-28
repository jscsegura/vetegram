<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsTokenVetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vets', function (Blueprint $table) {
            $table->string('token', 255)->nullable()->after('pro');
            $table->string('email_token', 255)->nullable()->after('token');
            $table->date('expire')->nullable()->after('email_token');
            $table->date('last_process')->nullable()->default('2024-01-01')->after('expire');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vets', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->dropColumn('email_token');
            $table->dropColumn('expire');
            $table->dropColumn('last_process');
        });
    }
}
