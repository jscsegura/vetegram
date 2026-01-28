<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTablePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->nullable();
            $table->integer('id_vet')->nullable();
            $table->string('currency', 255)->nullable();
            $table->string('amount', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->string('responseText', 255)->nullable();
            $table->string('auth', 255)->nullable();
            $table->string('orderNumber', 255)->nullable();
            $table->integer('orderid')->nullable();
            $table->text('hash')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
