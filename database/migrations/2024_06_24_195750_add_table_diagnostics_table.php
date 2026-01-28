<?php

use App\Models\Menu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableDiagnosticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostics', function (Blueprint $table) {
            $table->id();
            $table->string('title_es')->nullable();
            $table->string('title_en')->nullable();
            $table->integer('enabled')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Menu::create([
            'title' => 'Diagnosticos',
            'route' => 'wp.diagnostic.index',
            'icon' => ' fa-stethoscope',
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
        Schema::dropIfExists('diagnostics');
    }
}
