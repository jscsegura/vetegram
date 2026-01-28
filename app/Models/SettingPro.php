<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SettingPro extends Model implements Auditable {

    use \OwenIt\Auditing\Auditable;

    protected $table = 'setting_pros';

    protected $fillable = [
        'id', 'title_es', 'title_en', 'pro', 'enabled', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Configuración rubros PRO';
    }

}
