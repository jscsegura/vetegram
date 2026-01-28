<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\InventoryLogs;
use App\Enums\MovementType;
use App\Enums\DocumentType;
use App\Enums\MovementStatus;

class Inventory extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'inventories';

    protected $fillable = [
        'id',
        'id_vet',
        'title',
        'description',
        'barcode',
        'code',
        'subprice',
        'price',
        'instructions',
        'type',
        'cabys',
        'rate',
        'unit',
        'markeplace',
        'vet',
        'enabled',
        'quantity',
        'created_at',
        'updated_at'
    ];

    public function generateTags(): array
    {
        return Audit::getTags();
    }

    public function getModelName()
    {
        return 'Inventory';
    }

    /**
     * Increases the inventory and logs the movement.
     *
     * @param float        $quantity      Quantity to increase.
     * @param string       $documentId    Associated document ID.
     * @param DocumentType $documentType  Type of document (default is FACTURA).
     * @param string|null  $notes         Additional notes.
     * @param int       $user          User ID.
     * 
     * @return void
     */
    public function increaseInventory(
        float $quantity,
        string $documentId,
        DocumentType $documentType = DocumentType::FACTURA,
        ?string $notes = null,
        int $user
    ): void {
        // Actualiza la cantidad en inventario.
        $this->quantity += $quantity;
        $this->save();

        // Registra el movimiento de entrada.
        $this->registerMovement(MovementType::ENTRADA, $documentType, $documentId, $quantity, $notes, $user);
    }

    /**
     * Decreases the inventory and logs the movement.
     *
     * @param float        $quantity      Quantity to decrease.
     * @param string       $documentId    Associated document ID.
     * @param DocumentType $documentType  Type of document (default is FACTURA).
     * @param string|null  $notes         Additional notes.
     * @param int       $user          User ID.
     * 
     * @throws \Exception If the inventory quantity is insufficient.
     * @return void
     */
    public function decreaseInventory(
        float $quantity,
        string $documentId,
        DocumentType $documentType = DocumentType::FACTURA,
        ?string $notes = null,
        int $user
    ): void {
        // Valida que haya suficiente inventario.
        if ($this->quantity < $quantity) {
            throw new \Exception("Cantidad insuficiente en inventario.");
        }

        // Actualiza la cantidad en inventario.
        $this->quantity -= $quantity;
        $this->save();

        // Registra el movimiento de salida.
        $this->registerMovement(MovementType::SALIDA, $documentType, $documentId, $quantity, $notes, $user);
    }

    /**
     * Registers a movement in the `inventory_logs` table.
     *
     * @param MovementType $movementType Type of movement (entry/exit).
     * @param DocumentType $documentType Type of document.
     * @param string       $documentId   Associated document ID.
     * @param float        $quantity     Quantity involved.
     * @param string|null  $notes        Additional notes.
     * @param int       $user          User ID.
     * 
     * @return void
     */
    public function registerMovement(
        MovementType $movementType,
        DocumentType $documentType,
        string $documentId,
        float $quantity,
        ?string $notes = null,
        int $user
    ): void {
        InventoryLogs::create([
            'movement_type'   => $movementType,
            'document_type'   => $documentType,
            'movement_status' => MovementStatus::ACTIVO,
            'user_id'         => $user ?? null,
            'inventory_id'    => $this->id,
            'quantity'        => $quantity,
            'document_id'     => $documentId,
            'notes'           => $notes,
        ]);
    }
}
