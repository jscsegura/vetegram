<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class VaccineItem extends Model implements Auditable {

    use SoftDeletes, Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'vaccine_items';

    protected $fillable = [
        'id', 'type', 'title_es', 'title_en', 'interval', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'title_es', 'title_en'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Items de vacunas';
    }

}
