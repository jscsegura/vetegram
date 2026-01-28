<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Searchable;

class PhysicalSuboption extends Model implements Auditable {

    use SoftDeletes, Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'physical_suboptions';

    protected $fillable = [
        'id', 'id_option', 'title_es', 'title_en', 'type', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'id_option', 'title_es', 'title_en'
    ];

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Sub opciones examen fisico';
    }

    public static function getSubOptions($idOption = 0) {
        $options = PhysicalSuboption::where('id_option', '=', $idOption)->where('enabled', '=', 1)->get();

        return $options;
    }

}