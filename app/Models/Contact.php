<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Contact extends Model implements Auditable {

    use Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'contacts';

    protected $fillable = [
        'id', 'name', 'email', 'message', 'ip', 'browser', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'name', 'email', 'message', 'ip', 'browser'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Contactos';
    }

}
