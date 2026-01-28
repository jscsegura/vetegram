<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Vaccine extends Model implements Auditable {

    use SoftDeletes, Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'vaccines';

    protected $fillable = [
        'id', 'section', 'id_pet', 'id_owner', 'id_doctor', 'doctor_name', 'doctor_code', 'name', 'date', 'brand', 'batch', 'expire', 'photo', 'interval', 'next_date', 'id_vet_created', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'id_pet', 'name'
    ];

    function getDoctor() {
        return $this->hasOne('App\Models\User', 'id', 'id_doctor')->select(['id', 'name', 'signature']);
    }

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Vacunas';
    }

}
