<?php

use App\Models\Menu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableVacinesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccine_items', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->nullable()->default(1)->comment('1: vacunas, 2: desparacitaciones');
            $table->string('title_es')->nullable();
            $table->string('title_en')->nullable();
            $table->integer('interval')->nullable()->default(0);
            $table->integer('enabled')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Menu::create([
            'title' => 'Vacunas',
            'route' => 'wp.vaccine.index',
            'icon' => ' fa-deaf',
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
        Schema::dropIfExists('vaccine_items');
    }
}
