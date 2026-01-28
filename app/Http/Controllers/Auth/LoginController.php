<?php

namespace App\Http\Controllers\Auth;

use App\Console\Commands\sendNotifieds;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Notifications;
use App\Models\Reminder;
use App\Models\Setting;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller {
    
    public function __construct() {}
    
    public function forgot() {
        return view('auth.forgot');
    }

    public function login(Request $request) {
        
        if (Auth::guard('web')->attempt(['email' => $request->emailInput, 'password' => $request->passwordInput, 'enabled' => 1, 'lock' => 0], $request->remember)) {
            $user = User::select('id', 'email', 'name', 'rol_id', 'enabled', 'complete', 'last_login')->where('email', '=', $request->emailInput)->first();

            if(in_array($user->rol_id, [3,4,5,6,7,8])) {
                $user->last_login = date('Y-m-d H:i:s');
                $user->update();

                $notifieds = Reminder::where('created_by', '=', $user->id)->where('status', '=', 0)->where('read', '=', 0)->count();
                session(['notifieds' => $notifieds]);

                Audit::create([
                    'user_type' => 'Login', 
                    'user_id' => $user->id, 
                    'event' => 'login', 
                    'auditable_type' => 'Login', 
                    'auditable_id' => $user->id, 
                    'old_values' => json_encode([]), 
                    'new_values' => json_encode(['login' => 'true', 'id' => $user->id, 'name' => $user->name]), 
                    'url' => '', 
                    'ip_address' => '', 
                    'user_agent' => '', 
                    'tags' => json_encode(["id" => $user->id,"name" => $user->name,"lastname" => "","email" => $user->email,"guard" => "Web"])
                ]);

                if($user->complete == 0) {
                    return redirect(route('register.complete-profile'));
                }

                return redirect(route('dash'));
                        
            }else{
                Auth::guard('web')->logout();
                Session::flush();
                
                session()->flash('error', trans('auth.login.controller.dont.register'));
            }
        }
        
        $user = User::select('id', 'name', 'email', 'rol_id', 'enabled', 'lock')->where('email', '=', $request->emailInput)->whereIn('rol_id', [3,4,5,6,7,8])->first();
        if(isset($user->id)) {
            if($user->lock == 1) {
                session()->flash('error', trans('auth.login.controller.user.lock'));
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

                session()->flash('error', trans('auth.login.controller.confirm.pass'));
            }else{
                session()->flash('error', trans('auth.login.controller.incorrect'));
            }
        }else{
            session()->flash('error', trans('auth.login.controller.dont.register'));
        }        
        
        return redirect()->back();
    }

    public function loginAjax(Request $request) {
        
        if (Auth::guard('web')->attempt(['email' => $request->emailInput, 'password' => $request->passwordInput, 'enabled' => 1, 'lock' => 0, 'complete' => 1, 'rol_id' => $request->rol], $request->remember)) {
            $user = User::select('id', 'email', 'name', 'rol_id', 'enabled', 'complete', 'last_login')->where('email', '=', $request->emailInput)->first();

            if(in_array($user->rol_id, [$request->rol])) {
                $user->last_login = date('Y-m-d H:i:s');
                $user->update();

                $notifieds = Reminder::where('created_by', '=', $user->id)->where('status', '=', 0)->where('read', '=', 0)->count();
                session(['notifieds' => $notifieds]);

                Audit::create([
                    'user_type' => 'Login', 
                    'user_id' => $user->id, 
                    'event' => 'login', 
                    'auditable_type' => 'Login', 
                    'auditable_id' => $user->id, 
                    'old_values' => json_encode([]), 
                    'new_values' => json_encode(['login' => 'true', 'id' => $user->id, 'name' => $user->name]), 
                    'url' => '', 
                    'ip_address' => '', 
                    'user_agent' => '', 
                    'tags' => json_encode(["id" => $user->id,"name" => $user->name,"lastname" => "","email" => $user->email,"guard" => "Web"])
                ]);

                return response()->json(['error' => '', 'login' => 'success']);
                        
            }else{
                Auth::guard('web')->logout();

                return response()->json(['error' => trans('auth.login.controller.user.rol'), 'login' => 'error']);
            }
        }else{
            return response()->json(['error' => trans('auth.login.controller.user.lock'), 'login' => 'error']);
        }
    }

    public function loginSocialNetwork(Request $request) {

        $social = $request->network;
        $socialEmail = '';
        $image = '';
        
        if($social == 'google') {
            $setting = Setting::getSocialSetting();
            $socialConfig = [
                'client_id' => $setting->google_id,
                'client_secret' => $setting->google_secret,
                'redirect' => route('callback.social.login', 'google')
            ];
            config(['services.google' => $socialConfig]);

            $user = Socialite::driver('google')->user();

            if((isset($user->id)) && (isset($user->email)) && ($user->email != '')) {
                $socialEmail = $user->email;
                $image = $user->avatar;
            }
        }
        if($social == 'facebook') {
            $setting = Setting::getSocialSetting();
            $socialConfig = [
                'client_id' => $setting->facebook_id,
                'client_secret' => $setting->facebook_secret,
                'redirect' => route('callback.social.login', 'facebook')
            ];
            config(['services.facebook' => $socialConfig]);

            $user = Socialite::driver('facebook')->user();

            if((isset($user->id)) && (isset($user->email)) && ($user->email != '')) {
                $socialEmail = $user->email;
                $image = $user->avatar;
            }
        }

        if($socialEmail != '') {
            $user = User::select('id', 'email', 'rol_id', 'enabled', 'complete', 'facebook', 'google', 'photo')->where('email', '=', $socialEmail)->first();
            if (isset($user->id)) {
                Auth::guard('web')->loginUsingId($user->id);

                if(($user[$social] == 0)||($user['enabled'] == 0)) {
                    $user[$social] = 1;
                    $user['enabled'] = 1;
                    $user['email_verified_at'] = date('Y-m-d H:i:s');
                    if($user->photo == '') {
                        $user->photo = $image;
                    }
                    $user->update();
                }

                if(in_array($user->rol_id, [3,4,5,6,7,8])) {
                    switch ($user->rol_id) {
                        case '3'://Veterinary administrator
                            if($user->complete == 0) {
                                return redirect(route('register.complete-profile'));
                            }
                            return redirect(route('dash'));
                            break;
                        case '4'://Veterinary 
                            return redirect(route('dash'));
                            break;
                        case '5'://Cashier
                            return redirect(route('dash'));
                            break;
                        case '6'://Groomer
                            return redirect(route('dash'));
                            break;
                        case '7'://Accountant
                            return redirect(route('dash'));
                            break;
                        case '8'://Customer
                            if($user->complete == 0) {
                                return redirect(route('register.complete-profile'));
                            }
                            return redirect(route('dash'));
                            break;
                        default:
                            break;
                    }
                }else{
                    return redirect()->route('login.logout');
                }
            }else{
                session()->flash('error', trans('auth.login.controller.dont.register'));
            }
        }else{
            session()->flash('error', trans('auth.login.controller.dont.register'));
        }

        return redirect()->route('home.index');
    }

    public function loginFacebook (Request $request) {
        $setting = Setting::getSocialSetting();
        $socialConfig = [
            'client_id' => $setting->facebook_id,
            'client_secret' => $setting->facebook_secret,
            'redirect' => route('callback.social.login', 'facebook')
        ];
        config(['services.facebook' => $socialConfig]);

        return Socialite::driver('facebook')->redirect();
    }

    public function loginGoogle (Request $request) {
        $setting = Setting::getSocialSetting();
        $socialConfig = [
            'client_id' => $setting->google_id,
            'client_secret' => $setting->google_secret,
            'redirect' => route('callback.social.login', 'google')
        ];
        config(['services.google' => $socialConfig]);

        return Socialite::driver('google')->redirect();
    }

    public function logout() {
        Auth::guard('web')->logout();
        Session::flush();
        return redirect()->route('home.index');
    }

}