<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhysicalCategoryUser extends Model {

    protected $table = 'physical_category_users';

    protected $fillable = [
        'id', 'id_vet', 'id_category', 'options', 'created_at', 'updated_at'
    ];

}
