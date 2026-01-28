<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AppointmentRecipe extends Model implements Auditable {

    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'appointment_recipes';

    protected $fillable = [
        'id', 'id_appointment', 'id_pet', 'created_by', 'id_vet_created', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function detail () {
        return $this->hasMany(AppointmentRecipeDetails::class, 'id_recipe', 'id');
    }

    function getDoctor() {
        return $this->hasOne('App\Models\User', 'id', 'created_by')->select(['id', 'name']);
    }

    public function getModelName() {
        return 'Recetas';
    }

}
