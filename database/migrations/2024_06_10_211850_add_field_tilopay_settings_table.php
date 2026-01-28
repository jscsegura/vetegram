<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTilopaySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('price_pro', 12,2)->nullable()->default(0)->after('max_storage_pro');
            $table->string('tilopay_key', 255)->nullable()->default('')->after('price_pro');
            $table->string('tilopay_user', 255)->nullable()->default('')->after('tilopay_key');
            $table->string('tilopay_pass', 255)->nullable()->default('')->after('tilopay_user');
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
            $table->dropColumn('price_pro');
            $table->dropColumn('tilopay_key');
            $table->dropColumn('tilopay_user');
            $table->dropColumn('tilopay_pass');
        });
    }
}
