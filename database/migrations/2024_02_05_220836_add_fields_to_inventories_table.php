<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('type', 50)->nullable()->default('')->after('instructions');
            $table->string('cabys', 255)->nullable()->default('')->after('type');
            $table->string('rate', 50)->nullable()->default('')->after('cabys');
            $table->string('unit', 50)->nullable()->default('')->after('rate');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('cabys');
            $table->dropColumn('rate');
            $table->dropColumn('unit');
        });
    }
}
