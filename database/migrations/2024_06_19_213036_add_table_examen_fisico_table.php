<?php

use App\Models\Menu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableExamenFisicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title_es')->nullable();
            $table->string('title_en')->nullable();
            $table->integer('enabled')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('physical_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_category')->nullable();
            $table->string('title_es')->nullable();
            $table->string('title_en')->nullable();
            $table->integer('type')->nullable()->default(0)->comment('1:text, 2:number, 3:radio');
            $table->integer('enabled')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('physical_suboptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_option')->nullable();
            $table->string('title_es')->nullable();
            $table->string('title_en')->nullable();
            $table->integer('type')->nullable()->default(0)->comment('1:text, 2:number, 3:radio');
            $table->integer('enabled')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Menu::create([
            'title' => 'Examen Fisico',
            'route' => 'wp.physical.index',
            'icon' => 'fa-ambulance',
            'order' => 1,
            'enabled' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('physical_categories');
        Schema::dropIfExists('physical_options');
        Schema::dropIfExists('physical_suboptions');
    }
}
