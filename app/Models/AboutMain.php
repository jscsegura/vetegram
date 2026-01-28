<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AboutMain extends Model implements Auditable {

    use \OwenIt\Auditing\Auditable;

    protected $table = 'about_mains';

    protected $fillable = [
        'id', 'title_es', 'title_en', 'description_es', 'description_en', 'image', 'enabled', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Nosotros';
    }

}