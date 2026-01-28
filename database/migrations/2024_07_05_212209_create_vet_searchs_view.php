<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVetSearchsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW view_vet_searchs 
            AS
            select id, 
                country,
                social_name, 
                company, 
                address, 
                province, 
                canton, 
                district, 
                phone, 
                specialities, 
                schedule,
                resume,
                email,
                website,
                (SELECT GROUP_CONCAT(name SEPARATOR ', ') AS doctors FROM users us where us.id_vet = v.id and us.rol_id in (3,4,5,6) and us.code != '' and us.enabled = 1 and us.lock = 0 and us.complete = 1 and us.deleted_at is null) as doctors 
            from vets v where v.deleted_at is null;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
