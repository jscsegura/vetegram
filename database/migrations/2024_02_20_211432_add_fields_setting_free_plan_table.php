<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSettingFreePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('max_appointment_free')->nullable()->default(0)->after('environment_invoice');
            $table->integer('max_user_free')->nullable()->default(0)->after('max_appointment_free');
            $table->integer('max_storage_free')->nullable()->default(0)->after('max_user_free');

            $table->integer('max_appointment_pro')->nullable()->default(0)->after('max_storage_free');
            $table->integer('max_user_pro')->nullable()->default(0)->after('max_appointment_pro');
            $table->integer('max_storage_pro')->nullable()->default(0)->after('max_user_pro');
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
            $table->dropColumn('max_appointment_free');
            $table->dropColumn('max_user_free');
            $table->dropColumn('max_storage_free');
            $table->dropColumn('max_appointment_pro');
            $table->dropColumn('max_user_pro');
            $table->dropColumn('max_storage_pro');
        });
    }
}
