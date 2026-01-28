<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\Model;

class MedicalCollege extends Model {

    use Searchable;

    protected $table = 'medical_colleges';

    protected $fillable = [
        'id', 'code', 'name', 'dni', 'category', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'code', 'name', 'dni', 'category'
    ];

}
