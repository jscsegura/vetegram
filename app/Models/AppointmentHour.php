<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AppointmentHour extends Model implements Auditable {

    use \OwenIt\Auditing\Auditable;

    protected $table = 'appointment_hours';

    protected $fillable = [
        'id', 'id_user', 'date', 'hour', 'status', 'expire', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Horarios';
    }

}
