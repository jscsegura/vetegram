<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsPetsAgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->date('age')->nullable()->after('photo');
            $table->string('gender', 255)->nullable()->after('age');
            $table->integer('castrate')->nullable()->default(0)->after('gender');
            $table->string('color', 255)->nullable()->after('castrate');
            $table->string('alimentation', 255)->nullable()->after('color');
            $table->string('blood', 255)->nullable()->after('alimentation');
            $table->string('disease', 255)->nullable()->after('blood');
            $table->integer('dead_flag')->nullable()->default(0)->after('disease');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('gender');
            $table->dropColumn('castrate');
            $table->dropColumn('color');
            $table->dropColumn('alimentation');
            $table->dropColumn('blood');
            $table->dropColumn('disease');
            $table->dropColumn('dead_flag');
        });
    }
}
