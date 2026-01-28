<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket')->nullable();
            $table->integer('id_vet')->nullable();
            $table->string('consecutive', 255)->nullable();
            $table->string('clave', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('type_dni', 255)->nullable();
            $table->string('dni', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('payment', 100)->nullable();
            $table->string('type_payment', 10)->nullable();
            $table->string('currency', 10)->nullable();
            $table->decimal('total', 12,2)->nullable()->default(0);
            $table->string('errors', 255)->nullable();
            $table->integer('status')->nullable()->comment('0:pending, 1: approved, 2:rejected');
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
        Schema::dropIfExists('invoices');
    }
}
