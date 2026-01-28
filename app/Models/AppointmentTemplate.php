<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AppointmentTemplate extends Model implements Auditable {

    use \OwenIt\Auditing\Auditable;

    protected $table = 'appointment_templates';

    protected $fillable = [
        'id', 'id_user', 'day', 'hour', 'created_at', 'updated_at'
    ];
    
    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Plantillas horarios';
    }

}
