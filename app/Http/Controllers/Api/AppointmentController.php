<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Authentication;
use App\Http\Controllers\AppointmentController as AppointmentMainController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller {
    
    public function __construct() {}
    
    public function index(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true
        ]);

        $params = (new AppointmentMainController())->index($request);
        return response()->json($params, 200);        
    }

    public function view(Request $request) {
        $token = Authentication::validToken($request->token, true);

        $userid = $token['user_id'];

        Auth::guard('web')->loginUsingId($userid);

        $request->merge([
            "api" => true,
            "id" => $request->id
        ]);

        $params = (new AppointmentMainController())->view($request);
        return response()->json($params, 200);        
    }

}