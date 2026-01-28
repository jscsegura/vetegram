<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalBreedVets extends Model {

    protected $table = 'animal_breed_vets';

    protected $fillable = [
        'id', 'id_breed', 'id_vet', 'created_at', 'updated_at'
    ];

}
