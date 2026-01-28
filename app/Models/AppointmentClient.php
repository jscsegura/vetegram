<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AppointmentClient extends Model implements Auditable {

    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'appointment_clients';

    protected $fillable = [
        'id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'reason', 'diagnosis',
        'breed_grooming', 'image_grooming', 'desc_grooming', 'status', 'symptoms', 'history', 'physical', 'differential', 'differential_other', 
        'definitive', 'definitive_other', 'treatment', 'reminder', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    protected $auditExclude = [
        'reminder'
    ];

    public function getModelName() {
        return 'Citas';
    }

    function getPet() {
        return $this->hasOne('App\Models\Pet', 'id', 'id_pet')->select(['id', 'name', 'photo']);
    }

    function getClient() {
        return $this->hasOne('App\Models\User', 'id', 'id_owner')->select(['id', 'name', 'email', 'phone']);
    }

    function getDoctor() {
        return $this->hasOne('App\Models\User', 'id', 'id_user')->select(['id', 'id_vet', 'name', 'email', 'phone', 'photo']);
    }

    public function getLastNote () {
        return $this->hasMany(AppointmentNote::class, 'id_appointment', 'id')->limit(1)->orderBy('id', 'desc');
    }

    public function getAllNotes () {
        return $this->hasMany(AppointmentNote::class, 'id_appointment', 'id')->orderBy('id', 'desc');
    }

    public function getRecipesId () {
        return $this->hasMany(AppointmentRecipe::class, 'id_appointment', 'id')->orderBy('id', 'desc');
    }

}
