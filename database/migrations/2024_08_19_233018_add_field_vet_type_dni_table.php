<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldVetTypeDniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vets', function (Blueprint $table) {
            $table->integer('type_dni')->nullable()->after('id');
            $table->string('dni', 255)->nullable()->after('type_dni');
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
            $table->dropColumn('type_dni');
            $table->dropColumn('dni');
        });
    }
}
