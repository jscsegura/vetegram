<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTableMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('route', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->integer('order')->nullable()->default(0);
            $table->integer('enabled')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $params = [
            [
                'id' => 1,
                'title' => 'Usuarios',
                'route' => 'wp.users.index',
                'icon' => 'fa-users',
                'order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 2,
                'title' => 'Paises',
                'route' => 'wp.countries.index',
                'icon' => 'fa-globe',
                'order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 3,
                'title' => 'Especialidades',
                'route' => 'wp.specialties.index',
                'icon' => 'fa-th-list',
                'order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 4,
                'title' => 'Idiomas',
                'route' => 'wp.language.index',
                'icon' => 'fa-language',
                'order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 5,
                'title' => 'Tipos de animal',
                'route' => 'wp.animal-types.index',
                'icon' => 'fa-th-list',
                'order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 6,
                'title' => 'Razas de animal',
                'route' => 'wp.animal-breed.index',
                'icon' => 'fa-th-list',
                'order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 7,
                'title' => 'Colegio de vet',
                'route' => 'wp.college.index',
                'icon' => 'fa-database',
                'order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 8,
                'title' => 'Bitácora',
                'route' => 'wp.logs.index',
                'icon' => 'fa-code',
                'order' => 1,
                'enabled' => 1
            ]
        ];
        
        DB::table('menus')->insert($params);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
