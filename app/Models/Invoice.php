<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Invoice extends Model implements Auditable {

    use Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'invoices';

    protected $fillable = [
        'id', 'proforma', 'ticket', 'id_vet', 'consecutive', 'clave', 'user_id', 'name', 'type_dni', 'dni', 'email', 'phone', 'payment', 'type_payment', 'currency', 
        'total', 'errors', 'status', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'name', 'email', 'consecutive', 'clave'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Facturas';
    }

}
