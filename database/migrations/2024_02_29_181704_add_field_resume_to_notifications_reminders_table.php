<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldResumeToNotificationsRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reminders', function (Blueprint $table) {
            $table->string('to_phone', 255)->nullable()->after('to');
            $table->text('resume')->nullable()->after('description');
            $table->integer('repeat')->default(0)->after('read');
            $table->integer('period')->default(0)->after('repeat');
            $table->integer('quantity')->default(0)->after('period');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reminders', function (Blueprint $table) {
            $table->dropColumn('to_phone');
            $table->dropColumn('resume');
            $table->dropColumn('repeat');
            $table->dropColumn('period');
            $table->dropColumn('quantity');
        });
    }
}
