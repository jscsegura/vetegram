<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PetController as PetMainController;
use App\Http\Controllers\AppointmentController as AppointmentMainController;
use App\Models\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller {
    
    public function __construct() {}
    
    public function index(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new PetMainController())->myPets($request);
        return response()->json($params, 200);
    }

    public function petSave(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new PetMainController())->savePet($request);
        return response()->json($params, 200);
    }

    public function petDetail(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new PetMainController())->detail($request);
        return response()->json($params, 200);
    }

    public function petAttach(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new PetMainController())->attach($request);
        return response()->json($params, 200);
    }

    public function petVaccines(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new PetMainController())->vaccines($request);
        return response()->json($params, 200);
    }

    public function petRecipes(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new PetMainController())->recipes($request);
        return response()->json($params, 200);
    }

    public function petDelete(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new PetMainController())->delete($request);
        return $params;
    }

    public function updatePhoto(Request $request) {
        $token = Authentication::validToken($request->token2, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new PetMainController())->savePhoto($request);
        return response()->json($params, 200);
    }

    public function editPet(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new PetMainController())->editPet($request);
        return response()->json($params, 200);
    }

    public function saveAttach(Request $request) {
        $token = Authentication::validToken($request->token3, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new AppointmentMainController())->saveAttach($request);
        return $params;
    }

}