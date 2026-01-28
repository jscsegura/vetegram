<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTableProvincesWithDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->integer('enabled')->default(0);
            $table->timestamps();
        });

        Schema::table('provinces', function (Blueprint $table) {
            $provinceList = [
				["id"=>1,"title"=>"San José","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>2,"title"=>"Alajuela","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>3,"title"=>"Cartago","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>4,"title"=>"Heredia","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>5,"title"=>"Guanacaste","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>6,"title"=>"Puntarenas","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"],
                ["id"=>7,"title"=>"Limón","enabled"=>1,"created_at"=>"2023-06-01 01:00:00","updated_at"=>"2023-06-01 01:00:00"]
			];
            
			DB::table('provinces')->insert($provinceList);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}
