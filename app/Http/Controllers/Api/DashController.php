<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashController extends Controller {
    
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

        $params = (new HomeController())->dash($requestService);
        return response()->json($params, 200);
    }

    public function Appointment_cancelOrReschedule(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new AppointmentController())->cancelOrReschedule($request);
        return $params;
    }

    public function Appointment_getHours(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new AppointmentController())->getHours($request);
        return $params;
    }

    public function Appointment_reserveHour(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new AppointmentController())->reserveHour($request);
        return $params;
    }

}