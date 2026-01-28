<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSubpriceInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->double('subprice', 12,2)->nullable()->default(0)->after('code');
        });

        Schema::table('invoice_details', function (Blueprint $table) {
            $table->double('subprice', 12,2)->nullable()->default(0)->after('line_type');
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
            $table->dropColumn('subprice');
        });

        Schema::table('invoice_details', function (Blueprint $table) {
            $table->dropColumn('subprice');
        });
    }
}
