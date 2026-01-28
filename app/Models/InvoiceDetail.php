<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InvoiceDetail extends Model implements Auditable {

    use \OwenIt\Auditing\Auditable;

    protected $table = 'invoice_details';

    protected $fillable = [
        'id', 'id_invoice', 'id_product', 'cabys', 'tax', 'rate', 'gravado', 'detail', 'description', 'line_type', 'subprice', 'price', 
        'quantity', 'total', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Detalle Factura';
    }

}
