<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SuscriptionCancel extends Model implements Auditable {

    use Searchable, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'suscription_cancels';

    protected $fillable = [
        'id', 'id_user', 'id_vet', 'reason', 'survey', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'id_vet', 'reason'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Cancelacion del plan';
    }

}
