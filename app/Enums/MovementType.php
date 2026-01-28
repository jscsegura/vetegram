<?php

namespace App\Enums;

enum MovementType: string
{
    case ENTRADA  = 'entrada';
    case SALIDA   = 'salida';
    case AJUSTE   = 'ajuste';
    case ANULACION = 'anulacion';
}

