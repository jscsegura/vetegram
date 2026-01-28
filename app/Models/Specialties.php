<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Specialties extends Model implements Auditable {

    use Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'specialties';

    protected $fillable = [
        'id', 'title_es', 'title_en', 'enabled', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'title_es'
    ];

    public static function getResumeList($list = '', $lang = 'es') {
        if($list == '') {
            $list = '[]';
        }

        $list = json_decode($list, true);
        $specialties = Specialties::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->whereIn('id', $list)->limit(4)->get();

        $names = '';
        foreach ($specialties as $specialty) {
            if($names != '') {$names .= ', ';}
            $names .= $specialty['title_' . $lang];
        }
        if(($names != '')&&(count($specialties) == 4)) {$names .= '...';}

        return $names;
    }

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Especialidades';
    }

}
