<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Service extends Model implements Auditable {

    use SoftDeletes, Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'services';

    protected $fillable = [
        'id', 'title_es', 'title_en', 'description_es', 'description_en', 'image', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'title_es', 'title_en', 'description_es', 'description_en'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Servicios';
    }

}