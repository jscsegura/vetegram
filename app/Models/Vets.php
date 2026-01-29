<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Vets extends Model implements Auditable {

    use SoftDeletes, Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'vets';

    protected $fillable = [
        'id', 'country', 'code', 'social_name', 'company', 'address', 'province',
        'canton', 'district', 'phone', 'specialities', 'species', 'languages', 'services',
        'email', 'website', 'schedule', 'resume', 'logo', 'lat', 'lng', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'social_name', 'company', 'phone'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Veterinarias';
    }

    public static function getUserMyVet($id) {
        $vets = User::select('id', 'name', 'email', 'rol_id')
            ->where('enabled', '=', 1)
            ->where('complete', '=', 1)
            ->where('id_vet', '=', $id)
            ->get();

        return $vets; 
    }

    public static function getVetCountry($id) {
        $vet = Vets::select('id', 'country')
            ->where('id', '=', $id)
            ->first();

        $country = 0;
        if(isset($vet->country)) {
            $country = $vet->country;
        }

        return $country; 
    }

}
