<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('id_vet')->nullable()->default(0);
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('barcode', 255)->nullable();
            $table->string('code', 100)->nullable();
            $table->double('price', 12,2)->nullable();
            $table->text('instructions')->nullable();
            $table->integer('markeplace')->nullable()->default(0);
            $table->integer('vet')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
