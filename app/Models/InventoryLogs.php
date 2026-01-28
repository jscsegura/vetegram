<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use \App\Enums\DocumentType;
use \App\Enums\MovementType;
use \App\Enums\MovementStatus;

class InventoryLogs extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    // Se actualiza el nombre de la tabla
    protected $table = 'inventory_logs';

    // Se actualizan los campos fillable, reemplazando 'id_vet' por 'vet_id' y 'id_inventory' por 'inventory_id'
    // Además, se agregan los nuevos campos de tipo movimiento y documento.
    protected $fillable = [
        'id',
        'movement_type',
        'document_type',
        'movement_status',
        'user_id',
        'inventory_id',
        'quantity',
        'document_id',
        'notes',
        'created_at',
        'updated_at'
    ];

    // Se mantienen los casts para convertir a enum
    protected $casts = [
        'movement_type'   => MovementType::class,
        'document_type'   => DocumentType::class,
        'movement_status' => MovementStatus::class,
    ];

    public function generateTags(): array
    {
        return Audit::getTags();
    }

    public function getModelName()
    {
        return 'Movimientos de inventario';
    }
}


