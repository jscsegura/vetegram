<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsNotificationsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('mailer')->nullable()->default(1)->after('signature');
            $table->integer('sms')->nullable()->default(0)->after('mailer');
            $table->integer('whatsapp')->nullable()->default(0)->after('sms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mailer');
            $table->dropColumn('sms');
            $table->dropColumn('whatsapp');
        });
    }
}
