<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AnimalBreed extends Model implements Auditable {

    use Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'animal_breeds';

    protected $fillable = [
        'id', 'type', 'title_es', 'title_en', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'title_es'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Razas';
    }

    public static function getBreed($id = 0, $lang = 'es') {
        $breed = AnimalBreed::select('id', 'title_' . $lang . ' as title')->where('id', '=', $id)->first();

        if(isset($breed->id)) {
            return $breed->title;
        }else{
            return '';
        }
    }

}
