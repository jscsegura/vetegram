<?php

use App\Models\Menu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title_es', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->string('description_es', 255)->nullable();
            $table->string('description_en', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('enabled')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Menu::create([
            'title' => 'Contacto',
            'route' => 'wp.contact.index',
            'icon' => 'fa-envelope',
            'order' => 1,
            'enabled' => 1
        ]);
        Menu::create([
            'title' => 'Sliders',
            'route' => 'wp.slider.index',
            'icon' => 'fa-columns',
            'order' => 1,
            'enabled' => 1
        ]);
        Menu::create([
            'title' => 'Servicios',
            'route' => 'wp.service.index',
            'icon' => 'fa-columns',
            'order' => 1,
            'enabled' => 1
        ]);
        Menu::create([
            'title' => 'Nosotros',
            'route' => 'wp.about.index',
            'icon' => 'fa-columns',
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
        Schema::dropIfExists('sliders');
    }
}
