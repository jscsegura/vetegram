<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAppointmenGroomingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_clients', function (Blueprint $table) {
            $table->integer('breed_grooming')->nullable()->default(0)->after('diagnosis');
            $table->integer('image_grooming')->nullable()->default(0)->after('breed_grooming');
            $table->string('desc_grooming', 255)->nullable()->default('')->after('image_grooming');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_clients', function (Blueprint $table) {
            $table->dropColumn('breed_grooming');
            $table->dropColumn('image_grooming');
            $table->dropColumn('desc_grooming');
        });
    }
}
