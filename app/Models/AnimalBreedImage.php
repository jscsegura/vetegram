<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AnimalBreedImage extends Model implements Auditable {

    use Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'animal_breed_images';

    protected $fillable = [
        'id', 'title_es', 'title_en', 'image', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'title_es'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Imagenes de razas';
    }

    public static function getImage($id = 0, $lang = 'es') {
        $image = AnimalBreedImage::select('id', 'title_' . $lang . ' as title', 'image')->where('id', '=', $id)->first();

        $result = ['title' => '', 'image' => ''];
        if(isset($image->id)) {
            return $result = ['title' => $image->title, 'image' => $image->image];
        }else{
            return $result;
        }
    }

}
