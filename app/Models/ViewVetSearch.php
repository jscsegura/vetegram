<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Searchable;

class ViewVetSearch extends Model {

    use Searchable;

    protected $table = 'view_vet_searchs';

    public $searchable = [
        'id', 'country', 'social_name', 'company', 'address', 'province', 'canton', 'district', 'phone', 'specialities', 'schedule', 'resume', 'email', 'website', 'doctors'
    ];

    public static function getTagsSearch($lang = 'es') {

        $specialties = Specialties::select('id', 'title_' . $lang . ' as title')->where('enabled', '=', 1)->get();
        $countries = Countries::select('id', 'title')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        $provinces   = Province::select('id', 'title')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        $cantons   = Canton::select('id', 'title')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        $districts = District::select('id', 'title')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        $views = ViewVetSearch::get();

        $querys = [];            
        foreach($specialties as $specialty) {
            array_push($querys, ['id' => 'spec-'.$specialty->id, 'socialname' => $specialty->title, 'company' => $specialty->title, 'email' => '', 'website' => '', 'address' => trans('dash.label.controller.speciality'), 'resume' => '', 'schedule' => '']);
        }
        foreach($countries as $country) {
            array_push($querys, ['id' => 'country-'.$country->id, 'socialname' => $country->title, 'company' => $country->title, 'email' => '', 'website' => '', 'address' => trans('dash.label.controller.country'), 'resume' => '', 'schedule' => '']);
        }
        foreach($provinces as $province) {
            array_push($querys, ['id' => 'province-'.$province->id, 'socialname' => $province->title, 'company' => $province->title, 'email' => '', 'website' => '', 'address' => trans('dash.label.controller.province'), 'resume' => '', 'schedule' => '']);
        }
        foreach($cantons as $canton) {
            array_push($querys, ['id' => 'canton-'.$canton->id, 'socialname' => $canton->title, 'company' => $canton->title, 'email' => '', 'website' => '', 'address' => trans('dash.label.controller.canton'), 'resume' => '', 'schedule' => '']);
        }
        foreach($districts as $district) {
            array_push($querys, ['id' => 'district-'.$district->id, 'socialname' => $district->title, 'company' => $district->title, 'email' => '', 'website' => '', 'address' => trans('dash.label.controller.district'), 'resume' => '', 'schedule' => '']);
        }
        foreach($views as $view) {
            array_push($querys, ['id' => 'vet-'.$view->id.'-'.rand(1111, 9999), 'socialname' => $view->social_name, 'company' => $view->company, 'email' => $view->email, 'website' => $view->website, 'address' => $view->address, 'resume' => strip_tags($view->resume), 'schedule' => strip_tags($view->schedule)]);
            $doctors = explode(',', $view->doctors);
            foreach($doctors as $doctor) {
                array_push($querys, ['id' => 'vet-'.$view->id.'-'.rand(1111, 9999), 'socialname' => $doctor, 'company' => $doctor, 'email' => '', 'website' => '', 'address' => $view->company, 'resume' => '', 'schedule' => '']);
            }
        }

        return $querys;
    }

}