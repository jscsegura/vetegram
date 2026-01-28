<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldOnlineBookingVetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('online_booking')->nullable()->default(1)->after('process');
        });

        Schema::table('vets', function (Blueprint $table) {
            $table->text('schedule')->nullable()->after('phone');
            $table->string('website', 255)->nullable()->after('schedule');
            $table->text('resume')->nullable()->after('website');
            $table->string('email', 255)->nullable()->after('resume');
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
            $table->dropColumn('online_booking');
        });

        Schema::table('vets', function (Blueprint $table) {
            $table->dropColumn('schedule');
            $table->dropColumn('website');
            $table->dropColumn('resume');
            $table->dropColumn('email');
        });
    }
}
