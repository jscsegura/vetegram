<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model {

    use SoftDeletes;

    protected $table = 'menus';

    protected $fillable = [
        'id', 'title', 'route', 'icon', 'order', 'enabled', 'created_at', 'updated_at'
    ];

    public function submenu() {
        return $this->hasMany(SubMenu::class, 'id_menu', 'id');
    }

}
