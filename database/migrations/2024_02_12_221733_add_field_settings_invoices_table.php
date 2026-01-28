<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSettingsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('user_invoice', 255)->nullable()->default('')->after('term_en');
            $table->string('pass_invoice', 255)->nullable()->default('')->after('user_invoice');
            $table->integer('environment_invoice')->nullable()->default(0)->after('pass_invoice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('user_invoice');
            $table->dropColumn('pass_invoice');
            $table->dropColumn('environment_invoice');
        });
    }
}
