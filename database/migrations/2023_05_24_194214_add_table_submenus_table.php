<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTableSubmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submenus', function (Blueprint $table) {
            $table->id();
            $table->integer('id_menu')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('route', 255)->nullable();
            $table->integer('enabled')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $params = [
            [
                'id_menu' => 1,
                'title' => '',
                'route' => '',
                'enabled' => 1
            ],
            [
                'id_menu' => 2,
                'title' => '',
                'route' => '',
                'enabled' => 1
            ]
        ];
        
        DB::table('submenus')->insert($params);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submenus');
    }
}
