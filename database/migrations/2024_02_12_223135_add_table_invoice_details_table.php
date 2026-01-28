<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_invoice')->nullable();
            $table->integer('id_product')->nullable();
            $table->string('cabys', 255)->nullable();
            $table->string('tax', 255)->nullable();
            $table->string('rate', 255)->nullable();
            $table->string('gravado', 255)->nullable();
            $table->string('detail', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('line_type', 255)->nullable();
            $table->decimal('price', 12,2)->nullable()->default(0);
            $table->integer('quantity')->nullable()->default(0);
            $table->decimal('total', 12,2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}
