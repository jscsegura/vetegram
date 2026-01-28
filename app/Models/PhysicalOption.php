<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Searchable;

class PhysicalOption extends Model implements Auditable {

    use SoftDeletes, Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'physical_options';

    protected $fillable = [
        'id', 'id_category', 'title_es', 'title_en', 'type', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'id_category', 'title_es', 'title_en'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Opciones examen fisico';
    }

}