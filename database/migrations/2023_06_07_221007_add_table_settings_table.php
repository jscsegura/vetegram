<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('email_host', 255)->nullable();
            $table->string('email_user', 255)->nullable();
            $table->string('email_pass', 255)->nullable();
            $table->string('email_port', 10)->nullable();
            $table->string('email_from', 255)->nullable();
            $table->string('email_tls', 255)->nullable();
            $table->string('google_id', 255)->nullable();
            $table->string('google_secret', 255)->nullable();
            $table->string('facebook_id', 255)->nullable();
            $table->string('facebook_secret', 255)->nullable();
            $table->text('term_es')->nullable();
            $table->text('term_en')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
