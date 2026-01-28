<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Language extends Model implements Auditable {

    use Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'languages';

    protected $fillable = [
        'id', 'title_es', 'title_en', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'title_es'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Idiomas';
    }

}
