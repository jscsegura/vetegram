<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller {
    
    public function __construct() {}
    
    public function index(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $requestService = new Request();
        $requestService->setMethod('POST');
        $requestService->request->add([
            "api" => true
        ]);

        $params = (new HomeController())->profile($requestService);
        return response()->json($params, 200);
    }

    public function setNotifications(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new HomeController())->setNotifications($request);
        return $params;
    }

    public function updateProfile(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new HomeController())->updateProfile($request);
        return response()->json($params, 200);
    }

    public function updatePhoto(Request $request) {
        $token = Authentication::validToken($request->token2, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new HomeController())->updatePhoto($request);
        return response()->json($params, 200);
    }

}