<?php

namespace App\Http\Controllers\Api;

use App\Console\Commands\sendNotifieds;
use App\Http\Controllers\Controller;
use App\Models\AnimalTypes;
use App\Models\Audit;
use App\Models\Authentication;
use App\Models\Countries;
use App\Models\Notifications;
use App\Models\Pet;
use App\Models\Province;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    
    public function __construct() {}
    
    public function login(Request $request) {
        
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::select('id', 'email', 'password', 'name', 'rol_id', 'enabled', 'complete', 'last_login', 'lock')
            ->where('email', '=', $request->email)
            ->where('rol_id', '=', 8)
            ->where('enabled', '=', 1)
            ->where('lock', '=', 0)
            ->first();

        if(isset($user->id)) {
        
            if (Hash::check($request->password, $user->password) ) {
                $user->last_login = date('Y-m-d H:i:s');
                $user->update();
    
                Audit::create([
                    'user_type' => 'Login', 
                    'user_id' => $user->id, 
                    'event' => 'login', 
                    'auditable_type' => 'Login', 
                    'auditable_id' => $user->id, 
                    'old_values' => json_encode([]), 
                    'new_values' => json_encode(['login' => 'true', 'id' => $user->id, 'name' => $user->name, 'from' => 'app']), 
                    'url' => '', 
                    'ip_address' => '', 
                    'user_agent' => '', 
                    'tags' => json_encode(["id" => $user->id,"name" => $user->name,"lastname" => "","email" => $user->email,"guard" => "app"])
                ]);

                $token = bin2hex(random_bytes(64));
                $token = $user->id . $token;

                $auth = new Authentication();
                $auth->id_user  = $user->id;
                $auth->token    = $token;
                $auth->platform = ((isset($request->platform))&&(isset($request->version))) ? $request->platform . '-' . $request->version : '';
                $auth->expire   = Authentication::setTimeSession();
                $auth->save();

                return response()->json(['type' => 'success', 'name' => $user->name, 'email' => $user->email, 'token' => $token, 'complete' => $user->complete], 200);
            }else{
                return response()->json(['type' => 'error', 'name' => '', 'email' => '', 'token' => '', 'error' => trans('auth.login.controller.incorrect')], 200);
            }
        } else {
            $user = User::select('id', 'name', 'email', 'rol_id', 'enabled', 'lock')->where('email', '=', $request->email)->first();

            if(isset($user->id)) {
                if($user->rol_id != 8) {
                    return response()->json(['type' => 'error', 'name' => '', 'email' => '', 'token' => '', 'error' => trans('auth.login.controller.user.rol')], 200);
                }elseif($user->lock == 1) {
                    return response()->json(['type' => 'error', 'name' => '', 'email' => '', 'token' => '', 'error' => trans('auth.login.controller.user.lock')], 200);
                }elseif($user->enabled == 0) {
                    $subject = trans('auth.register.email.verified');

                    $data = ['token' => User::encryptor('encrypt', $user->id . '||' . $user->email), 'email' => $user->email, 'name' => $user->name];
                    $template = view('emails.general.register', $data)->render();

                    $row = Notifications::create([
                        'id_user' => 0,
                        'to' => $user->email,
                        'subject' => $subject,
                        'description' => $template,
                        'attach' => '',
                        'email' => 1,
                        'sms' => 0,
                        'whatsapp' => 0,
                        'status' => 1,
                        'attemps' => 0
                    ]);

                    (new sendNotifieds)->sendEmail($row);

                    return response()->json(['type' => 'error', 'name' => '', 'email' => '', 'token' => '', 'error' => trans('auth.login.controller.confirm.pass')], 200);
                }else{
                    return response()->json(['type' => 'error', 'name' => '', 'email' => '', 'token' => '', 'error' => trans('auth.login.controller.dont.register')], 200);
                }
            }else{
                return response()->json(['type' => 'error', 'name' => '', 'email' => '', 'token' => '', 'error' => trans('auth.login.controller.dont.register')], 200);
            }
        }
    }

    public function verified(Request $request) {
        $token = (isset($request->token)) ? $request->token : '';

        $token = Authentication::validToken($token, true);

        $token['complete'] = 0;

        if((isset($token['user_id'])) && ($token['user_id'] != 0)) {
            $user = User::select('id', 'complete')->where('id', '=', $token['user_id'])->first();

            if(isset($user->id)) {
                $token['complete'] = $user->complete;
            }
        }

        return response()->json($token, 200);
    }

    public function completeProfile(Request $request) {

        $token = Authentication::validToken($request->token, true);

        $user = [];
        $countries = [];
        $provinces = [];
        $animaltypes = [];
        $pets = [];
        
        if($request->step == 1) {
            $user = User::select('id', 'name', 'email', 'phone', 'type_dni', 'dni')->where('id', '=', $token['user_id'])->first();
            $countries = Countries::select('id', 'title', 'phonecode', 'default')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
            $provinces = Province::select('id', 'title')->where('enabled', '=', 1)->orderBy('id', 'ASC')->get();
        }else{
            $user = User::select('id', 'name', 'email', 'phone', 'type_dni', 'dni')->where('id', '=', $token['user_id'])->first();
            $animaltypes = AnimalTypes::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();
            $pets = Pet::where('id_user', '=', $token['user_id'])->with(['getType', 'getBreed'])->get();
        }

        return response()->json(['user' => $user, 'countries' => $countries, 'provinces' => $provinces, 'animaltypes' => $animaltypes, 'pets' => $pets], 200);
    }

    public function completeProfileSave(Request $request) {
        $token = Authentication::validToken($request->token, true);
        
        $step = $request->step;

        if($step == 1) {
            $userrow = User::select('id', 'type_dni', 'dni', 'country', 'province', 'canton', 'district', 'phone', 'complete')->where('id', '=', $token['user_id'])->first();
            $userrow->type_dni = $request->idtype;
            $userrow->dni      = $request->idnumber;
            $userrow->country  = $request->country;
            $userrow->province = ($request->country == 53) ? $request->province : $request->province_alternate;
            $userrow->canton   = ($request->country == 53) ? $request->canton : $request->canton_alternate;
            $userrow->district = ($request->country == 53) ? $request->district : $request->district_alternate;
            $userrow->phone    = $request->phone;
            $userrow->update();

            return response()->json(['type' => 200], 200);
        }elseif($step == 2) {

            $userrow = User::select('id', 'type_dni', 'dni', 'country', 'province', 'canton', 'district', 'phone', 'complete')->where('id', '=', $token['user_id'])->first();

            if(isset($_POST['petname'])){
                for($i = 0;$i < count($_POST['petname']);$i++){
                    if($_POST['petname'][$i] != ""){
                        $pet = new Pet();
                        $pet->id_user = $token['user_id'];
                        $pet->name    = $_POST['petname'][$i];
                        $pet->type    = ($_POST['animaltype'][$i] != "") ? $_POST['animaltype'][$i] : 0;
                        $pet->breed   = ($_POST['breed'][$i] != "") ? $_POST['breed'][$i] : 0;
                        $pet->save();
                    }
                }
            }

            $userrow->complete = 1;
            $userrow->update();

            return response()->json(['type' => 200], 200);
        }
    }

    public function logout(Request $request) {
        $token = Authentication::where('token', '=', $request->token)->first();

        if(isset($token->id)) {
            $token->delete();
        }

        return response()->json(['type' => 'success'], 200);
    }

    public function getTerms() {
        $setting = Setting::select('term_es')->where('id', '=', 1)->first();

        return response()->json(['terms' => $setting->term_es], 200);
    }

}