<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Searchable;

class PhysicalCategory extends Model implements Auditable {

    use SoftDeletes, Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'physical_categories';

    protected $fillable = [
        'id', 'title_es', 'title_en', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'title_es', 'title_en'
    ];

    public function options () {
        return $this->hasMany(PhysicalOption::class, 'id_category', 'id')->where('enabled', '=', 1);
    }

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Categorias examen fisico';
    }

}
