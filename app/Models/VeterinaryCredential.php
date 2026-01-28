<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class VeterinaryCredential extends Model implements Auditable {

    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'veterinary_credentials';

    protected $fillable = [
        'id', 'id_vet', 'id_client', 'created_at', 'updated_at'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Permisos Historial';
    }

    public static function setCredentials($idClient = 0, $idVet = 0) {
        $credential = VeterinaryCredential::where('id_vet', '=', $idVet)->where('id_client', '=', $idClient)->first();

        if(!isset($credential->id)) {
            VeterinaryCredential::create([
                'id_vet' => $idVet,
                'id_client' => $idClient
            ]);
        }

        return true;
    }

    public static function userHasCredentials($idClient = 0) {
        $userInSession = Auth::guard('web')->user();
        
        $existCredentials = true;
        $id_vet = 0;

        if(in_array($userInSession->rol_id, [3,4,5,6,7])) {
            $credential = VeterinaryCredential::where('id_vet', '=', $userInSession->id_vet)->where('id_client', '=', $idClient)->first();
            
            if(!isset($credential->id)) {
                $existCredentials = false;
            }

            $id_vet = $userInSession->id_vet;
        }

        return ['access' => $existCredentials, 'id_vet' => $id_vet];
    }

}