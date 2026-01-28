<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolMenu extends Model {

    protected $table = 'rol_menus';

    protected $fillable = [
        'id', 'id_user', 'id_menu', 'created_at', 'updated_at'
    ];

}
