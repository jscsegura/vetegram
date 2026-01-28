<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Pet extends Model implements Auditable {

    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'pets';

    protected $fillable = [
        'id', 'id_user', 'name', 'type', 'breed', 'photo', 'age', 'gender', 'castrate', 'color', 'alimentation', 'blood', 'dead_flag', 'disease', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Mascotas';
    }

    function getUser() {
        return $this->hasOne('App\Models\User', 'id', 'id_user')->select(['id', 'name', 'email', 'phone', 'dni', 'country', 'province', 'canton', 'district']);
    }

    function getType() {
        return $this->hasOne('App\Models\AnimalTypes', 'id', 'type')->select(['id', 'title_es', 'title_en']);
    }

    function getBreed() {
        return $this->hasOne('App\Models\AnimalBreed', 'id', 'breed')->select(['id', 'title_es', 'title_en']);
    }

    public static function getAgeValue($date) {
        $date = new DateTime($date);
        
        $now = new DateTime();
        
        $diff = $now->diff($date);
        
        $years = $diff->y;
        $months = $diff->m;

        return $years . ' ' . trans('dash.label.years') . ', ' . $months . ' ' . trans('dash.label.months');
    }

}
