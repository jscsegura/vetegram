<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AppointmentRecipeDetails extends Model implements Auditable {

    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'appointment_recipe_details';

    protected $fillable = [
        'id', 'id_recipe', 'id_medicine', 'title', 'duration', 'id_take', 'take', 'quantity', 'instruction', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Detalle recetas';
    }

}