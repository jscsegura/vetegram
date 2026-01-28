<?php

namespace App\Enums;

enum DocumentType: string
{
    case FACTURA       = 'factura';
    case ORDEN_COMPRA  = 'orden_compra';
    case NOTA_CREDITO  = 'nota_credito';
    case AJUSTE_MANUAL = 'ajuste_manual';
}
