<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubMenu extends Model {

    use SoftDeletes;

    protected $table = 'submenus';

    protected $fillable = [
        'id', 'id_menu', 'title', 'route', 'enabled', 'created_at', 'updated_at'
    ];

}
