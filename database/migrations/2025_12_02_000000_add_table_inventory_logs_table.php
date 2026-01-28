<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableInventoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();

            // Se utilizan columnas de tipo string en lugar de enum para mayor flexibilidad.
            // Se recomienda validar los valores permitidos a nivel de aplicación.
            $table->string('movement_type');   // Valores sugeridos: entrada, salida, ajuste, anulacion.
            $table->string('document_type');   // Valores sugeridos: factura, orden_compra, nota_credito, ajuste_manual.
            $table->string('movement_status'); // Valores sugeridos: activo, anulado.

            // Uso de nombres de columnas convencionales para claves foráneas.
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('inventory_id')->constrained('inventories');
            
            $table->decimal('quantity', 8, 4);
            $table->string('document_id');
            $table->text('notes')->nullable();

            // Uso del helper timestamps para crear los campos created_at y updated_at.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_logs');
    }
}
