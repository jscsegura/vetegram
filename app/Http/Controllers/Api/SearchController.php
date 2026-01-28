<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use App\Models\Authentication;
use App\Models\User;
use App\Models\Vets;
use App\Models\ViewVetSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller {
    
    public function __construct() {}
    
    public function search(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        $user = User::where('id', '=', $userid)->first();

        /*** Start search querys ***/
        $querys = ViewVetSearch::getTagsSearch('es');
        /*** End search querys ***/
        
        $criterio  = '';
        if((isset($request->id[0])) && ($request->id[0] != null)) {
            $criterio = base64_decode($request->id[0]);
            $criterioExplode = explode(',', $criterio);
        }

        $filterSearch = 0;
        if((isset($criterioExplode))&&(count($criterioExplode) > 0)) {
            $filterSearch = 1;
            $specialty = [];
            $countries = [];
            $provinces = [];
            $cantons = [];
            $districts = [];
            $ids = [];
            foreach($criterioExplode as $key) {
                $aux = explode('-', $key);
                if($aux[0] == 'spec') {
                    array_push($specialty, $aux[1]);
                }
                if($aux[0] == 'country') {
                    array_push($countries, $aux[1]);
                }
                if($aux[0] == 'province') {
                    array_push($provinces, $aux[1]);
                }
                if($aux[0] == 'canton') {
                    array_push($cantons, $aux[1]);
                }
                if($aux[0] == 'district') {
                    array_push($districts, $aux[1]);
                }
                if($aux[0] == 'vet') {
                    array_push($ids, $aux[1]);
                }
            }

            $vets = ViewVetSearch::where(function($query) use ($specialty, $countries, $provinces, $cantons, $districts, $ids) {
                if(count($specialty) > 0) {
                    foreach ($specialty as $spec) {
                        $query->orWhere('specialities', 'LIKE', '%"' . $spec . '"%');
                    }
                }
                if(count($countries) > 0) {
                    foreach ($countries as $country) {
                        $query->orWhere('country', '=', $country);
                    }
                }
                if(count($provinces) > 0) {
                    foreach ($provinces as $province) {
                        $query->orWhere('province', '=', $province);
                    }
                }
                if(count($cantons) > 0) {
                    foreach ($cantons as $canton) {
                        $query->orWhere('canton', '=', $canton);
                    }
                }
                if(count($districts) > 0) {
                    foreach ($districts as $district) {
                        $query->orWhere('district', '=', $district);
                    }
                }
                if(count($ids) > 0) {
                    $query->orWhereIn('id', $ids);
                }
            })
            ->limit(100)->get();
        }else{   
            if(isset($user->country)) {
                $vets = ViewVetSearch::where('country', '=', $user->country)->limit(100)->get();
            } else {
                $vets = ViewVetSearch::limit(100)->get();
            }
        }
           
        $params = ['querys' => $querys, 'vets' => $vets, 'filterSearch' => $filterSearch];

        return response()->json($params, 200);
    }

    public function searchUsers(Request $request) {
        $token = Authentication::validToken($request->token, true);

        /*** Start search querys ***/
        $querys = ViewVetSearch::getTagsSearch('es');
        /*** End search querys ***/

        $id = $request->id;
        $vet = Vets::where('id', '=', $id)->first();

        $doctors = User::select('id', 'id_vet', 'name', 'photo', 'online_booking')
            ->where('id_vet', '=', $id)
            ->whereIn('rol_id', [3,4,5,6])
            ->where('code', '!=', '')
            ->where('enabled', '=', 1)
            ->where('lock', '=', 0)
            ->where('complete', '=', 1)
            ->with('getVet')
            ->get();

        $params = ['querys' => $querys, 'vet' => $vet, 'doctors' => $doctors];

        return response()->json($params, 200);
    }

    public function book(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $date = ((isset($request->date))&&($request->date != '')) ? base64_encode($request->date) : base64_encode(date('Y-m-d'));
        
        $request->merge([
            "api" => true,
            "vet_id" => User::encryptor('encrypt', $request->vet_id[0]),
            "date" => $date
        ]);
        
        $params = (new HomeController())->book($request);
        return response()->json($params, 200);        
    }

    public function reserveHour(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true,
            "id" => $request->id
        ]);
        
        $params = (new AppointmentController())->reserveHour($request);
        return response()->json($params, 200);    
    }

    public function getPetData(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $doctor = User::where('id', '=', User::encryptor('decrypt', $request->id_vet))->first();
        $id_vet = (isset($doctor->id_vet)) ? $doctor->id_vet : 0;

        $request->merge([
            "api" => true,
            "id" => $request->id,
            "id_vet" => $id_vet
        ]);
        
        $params = (new HomeController())->getPetData($request);
        return response()->json($params, 200);
    }

    public function getPetDataImages(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true,
            "id" => $request->id
        ]);
        
        $params = (new HomeController())->getPetDataImages($request);
        return response()->json($params, 200);
    }

    public function saveBook(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);
        
        $params = (new HomeController())->saveBook($request);
        return response()->json($params, 200);
    }

    public function getDetailAppointment(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true,
            "id" => $request->id[0]
        ]);
        
        $params = (new HomeController())->bookmessage($request);
        return response()->json($params, 200);
    }

}