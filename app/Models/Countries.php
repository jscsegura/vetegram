<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Countries extends Model implements Auditable {

    use Searchable, \OwenIt\Auditing\Auditable;

    protected $table = 'countries';

    public $searchable = [
        'id', 'title', 'iso2', 'iso3', 'phonecode'
    ];

    public static function getResumeLocation($country = 0, $province = '', $canton = '', $district = '', $address = '') {
        $provinceName = $province;
        $cantonsName  = $canton;
        $districtName = $district;
        
        if(($country != '') && ($country == '53')) {
            $province = Province::select('id', 'title')->where('id', '=', $province)->first();
            $canton   = Canton::select('id', 'title')->where('id', '=', $canton)->first();
            $district = District::select('id', 'title')->where('id', '=', $district)->first();

            $provinceName = (isset($province->title)) ? $province->title : '';
            $cantonsName  = (isset($canton->title)) ? $canton->title : '';
            $districtName = (isset($district->title)) ? $district->title : '';
        }

        $ubication = $provinceName;
        if($cantonsName != '') {
            if($ubication != '') {$ubication .= ', ';}
            $ubication .= $cantonsName;
        }
        if($districtName != '') {
            if($ubication != '') {$ubication .= ', ';}
            $ubication .= $districtName;
        }

        if($address != '') {
            if($ubication != '') {$ubication .= ', ';}
            $ubication .= $address;
        }

        return $ubication;
    }

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Paises';
    }

}
