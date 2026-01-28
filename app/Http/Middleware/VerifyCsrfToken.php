<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'owner/get-pet-data',
        'owner/get-pet-data-images',
        'register/get-location',
        'register/get-breed',
        'forgot',
        'register',
        'appointment-cancel-or-reschedule',
        'sendcontact',
        'appointment-send-recipe'
    ];
}
