<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTableCantonsWithDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cantons', function (Blueprint $table) {
            $table->id();
            $table->integer('id_province')->nullable();
            $table->string('title', 255)->nullable();
            $table->integer('enabled')->default(0);
            $table->timestamps();
        });

        Schema::table('cantons', function (Blueprint $table) {
            $cantonsList = [
                ["id"=>1,"id_province"=>1,"title"=>"San Jose","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>2,"id_province"=>1,"title"=>"Escazu","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>3,"id_province"=>1,"title"=>"Desamparados","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>4,"id_province"=>1,"title"=>"Puriscal","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>5,"id_province"=>1,"title"=>"Tarrazu","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>6,"id_province"=>1,"title"=>"Aserri","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>7,"id_province"=>1,"title"=>"Mora","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>8,"id_province"=>1,"title"=>"Goicoechea","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>9,"id_province"=>1,"title"=>"Santa Ana","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>10,"id_province"=>1,"title"=>"Alajuelita","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>11,"id_province"=>1,"title"=>"Vazquez de Coronado","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>12,"id_province"=>1,"title"=>"Acosta","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>13,"id_province"=>1,"title"=>"Tibas","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>14,"id_province"=>1,"title"=>"Moravia","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>15,"id_province"=>1,"title"=>"Montes de Oca","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>16,"id_province"=>1,"title"=>"Turrubares","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>17,"id_province"=>1,"title"=>"Dota","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>18,"id_province"=>1,"title"=>"Curridabat","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>19,"id_province"=>1,"title"=>"Perez Zeledon","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>20,"id_province"=>1,"title"=>"Leon Cortes","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>21,"id_province"=>2,"title"=>"Alajuela","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>22,"id_province"=>2,"title"=>"San Ramon","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>23,"id_province"=>2,"title"=>"Grecia","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>24,"id_province"=>2,"title"=>"San Mateo","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>25,"id_province"=>2,"title"=>"Atenas","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>26,"id_province"=>2,"title"=>"Naranjo","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>27,"id_province"=>2,"title"=>"Palmares","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>28,"id_province"=>2,"title"=>"Poas","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>29,"id_province"=>2,"title"=>"Orotina","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>30,"id_province"=>2,"title"=>"San Carlos","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>31,"id_province"=>2,"title"=>"Alfaro Ruiz","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>32,"id_province"=>2,"title"=>"Valverde Vega","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>33,"id_province"=>2,"title"=>"Upala","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>34,"id_province"=>2,"title"=>"Los Chiles","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>35,"id_province"=>2,"title"=>"Guatuso","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>36,"id_province"=>3,"title"=>"Cartago","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>37,"id_province"=>3,"title"=>"Paraiso","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>38,"id_province"=>3,"title"=>"La Union","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>39,"id_province"=>3,"title"=>"Jimenez","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>40,"id_province"=>3,"title"=>"Turrialba","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>41,"id_province"=>3,"title"=>"Alvarado","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>42,"id_province"=>3,"title"=>"Oreamuno","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>43,"id_province"=>3,"title"=>"El Guarco","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>44,"id_province"=>4,"title"=>"Heredia","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>45,"id_province"=>4,"title"=>"Barva","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>46,"id_province"=>4,"title"=>"Santo Domingo","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>47,"id_province"=>4,"title"=>"Santa Barbara","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>48,"id_province"=>4,"title"=>"San Rafael","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>49,"id_province"=>4,"title"=>"San Isidro","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>50,"id_province"=>4,"title"=>"Belen","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>51,"id_province"=>4,"title"=>"San Joaquin de Flores","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>52,"id_province"=>4,"title"=>"San Pablo","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>53,"id_province"=>4,"title"=>"Sarapiqui","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>54,"id_province"=>5,"title"=>"Liberia","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>55,"id_province"=>5,"title"=>"Nicoya","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>56,"id_province"=>5,"title"=>"Santa Cruz","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>57,"id_province"=>5,"title"=>"Bagaces","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>58,"id_province"=>5,"title"=>"Carrillo","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>59,"id_province"=>5,"title"=>"CaÃ±as","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>60,"id_province"=>5,"title"=>"Abangares","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>61,"id_province"=>5,"title"=>"Tilaran","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>62,"id_province"=>5,"title"=>"Nandayure","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>63,"id_province"=>5,"title"=>"La Cruz","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>64,"id_province"=>5,"title"=>"Hojancha","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>65,"id_province"=>6,"title"=>"Puntarenas","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>66,"id_province"=>6,"title"=>"Esparza","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>67,"id_province"=>6,"title"=>"Buenos Aires","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>68,"id_province"=>6,"title"=>"Montes de Oro","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>69,"id_province"=>6,"title"=>"Osa","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>70,"id_province"=>6,"title"=>"Aguirre","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>71,"id_province"=>6,"title"=>"Golfito","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>72,"id_province"=>6,"title"=>"Coto Brus","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>73,"id_province"=>6,"title"=>"Parrita","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>74,"id_province"=>6,"title"=>"Corredores","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>75,"id_province"=>6,"title"=>"Garabito","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>76,"id_province"=>7,"title"=>"Limon","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>77,"id_province"=>7,"title"=>"Pocosi","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>78,"id_province"=>7,"title"=>"Siquirres","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>79,"id_province"=>7,"title"=>"Talamanca","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>80,"id_province"=>7,"title"=>"Matina","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>81,"id_province"=>7,"title"=>"Guacimo","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"]
			];
            
			DB::table('cantons')->insert($cantonsList);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cantons');
    }
}
