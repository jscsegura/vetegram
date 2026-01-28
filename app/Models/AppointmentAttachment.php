<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AppointmentAttachment extends Model implements Auditable {

    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'appointment_attachments';

    protected $fillable = [
        'id', 'id_appointment', 'id_pet', 'title', 'folder', 'attach', 'size', 'created_by', 'id_vet_created', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Adjuntos';
    }

    public static function getExtensions($onlyImg = false) {
        if($onlyImg == true) {
            return '.jpg,.jpeg,.png,jpg,jpeg,png';
        }else{
            return '.doc,.docx,.jpg,.jpeg,.png,.pdf,.xls,.xlsx,doc,docx,jpg,jpeg,png,pdf,xls,xlsx';
        }
    }

}
