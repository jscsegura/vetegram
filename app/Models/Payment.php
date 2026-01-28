<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends Model implements Auditable {

    use Searchable, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'payments';

    protected $fillable = [
        'id', 'id_user', 'id_vet', 'currency', 'amount', 'code', 'responseText', 'auth', 'orderNumber', 'orderid', 'hash', 'created_at', 'updated_at', 'deleted_at' 
    ];

    public $searchable = [
        'id', 'code', 'responseText', 'auth', 'orderNumber', 'orderid', 'created_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Pagos';
    }

}
