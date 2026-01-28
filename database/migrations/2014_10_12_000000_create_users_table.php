<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('id_vet')->nullable();
            $table->integer('type_dni')->nullable();
            $table->string('dni', 255)->nullable();
            $table->string('name', 255);
            $table->string('lastname', 255);
            $table->string('email')->unique();
            $table->integer('country')->nullable();
            $table->string('province', 255)->nullable();
            $table->string('canton', 255)->nullable();
            $table->string('district', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('code', 50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('rol_id');
            $table->integer('facebook')->nullable()->default(0);
            $table->integer('google')->nullable()->default(0);
            $table->string('photo')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->double('rate', 12, 2)->default(0);
            $table->integer('pro')->nullable()->default(0);
            $table->integer('enabled')->nullable()->default(0);
            $table->integer('complete')->nullable()->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        $params = [
            [
                'id' => 1,
                'name' => 'Flock',
                'lastname' => 'Adm',
                'email' => 'hablemos@flockcr.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('123'),
                'rol_id' => 1,
                'facebook' => 0,
                'google' => 0,
                'photo' => '',
                'last_login' => date('Y-m-d H:i:s'),
                'rate' => 0,
                'enabled' => 1
            ]
        ];
        
        DB::table('users')->insert($params);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
