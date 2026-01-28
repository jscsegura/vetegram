<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVetDoctor extends Model {

    protected $table = 'user_vet_doctors';

    protected $fillable = [
        'id', 'id_client', 'id_vet', 'id_doctor', 'created_at', 'updated_at'
    ];

}
