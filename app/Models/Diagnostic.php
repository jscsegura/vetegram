<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Diagnostic extends Model implements Auditable {

    use SoftDeletes, Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'diagnostics';

    protected $fillable = [
        'id', 'title_es', 'title_en', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'title_es', 'title_en'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Diagnosticos';
    }

}