<?php

namespace App\Events;

use OwenIt\Auditing\Events\Auditing;

class AuditEventListener {

    public function handle(Auditing $event) {
        
        $model = $event->model;

    }
    
}
