<?php

namespace App\Http\Controllers\Wpanel;

use App\Console\Commands\sendNotifieds;
use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Menu;
use App\Models\Notifications;
use App\Models\RolMenu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.login.index');
    }

    public function login(Request $request) {
        
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'rol_id' => 1], $request->remember)) {
            $user = User::select('id', 'name', 'email', 'last_login')->where('email', '=', $request->email)->first();

            $user->last_login = date('Y-m-d H:i:s');
            $user->update();

            $roles = RolMenu::where('id_user', '=', $user->id)->pluck('id_menu');
            $menus = Menu::whereIn('id', $roles)->where('enabled', '=', 1)->with('submenu')->orderBy('title', 'asc')->get();
            
            session(['wpmenus' => $menus]);

            Audit::create([
                'user_type' => 'Login', 
                'user_id' => $user->id, 
                'event' => 'login', 
                'auditable_type' => 'Login', 
                'auditable_id' => $user->id, 
                'old_values' => json_encode([]), 
                'new_values' => json_encode(['login' => 'true', 'id' => $user->id, 'name' => $user->name, 'isvetegram' => 'true']), 
                'url' => '', 
                'ip_address' => '', 
                'user_agent' => '', 
                'tags' => json_encode(["id" => $user->id,"name" => $user->name,"lastname" => "","email" => $user->email,"guard" => "admin"])
            ]);

            return redirect(route('wp.home'));
        }

        $user = User::select('id', 'email')->where('email', '=', $request->email)->first();
        if(isset($user->id)) {
            session()->flash('error', 'La contraseña proporcionada es incorrecta');
        }else{
            session()->flash('error', 'Estas credenciales no coinciden con nuestros registros');
        }        
        
        return redirect()->back();
    }

    function forgot() {
        return view('wpanel.login.forgot');
    }

    function forgotProcess(Request $request) {
        $email = (isset($request->email)) ? $request->email : '';

        if($email != '') {
            $user = User::select('id', 'name', 'email')->where('email', '=', $email)->where('rol_id', '=', 1)->first();

            if(isset($user->id)) {
                $possible = '123456789abcdfghjkmnpqrstvwxyzABCDEFHKMNPQRTVWXYZ';
                $newPass = '';
                $i = 0;
                while ($i < 12) {
                    $newPass .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
                    $i++;
                }

                $user->password = Hash::make($newPass);
                $user->update();

                $subject = 'Solicitud de nueva contraseña';

                $data = ['token' => $newPass, 'name' => $user->name];
                $template = view('emails.general.wpforgot', $data)->render();

                $row = Notifications::create([
                    'id_user' => 0,
                    'to' => $email,
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

                session()->flash('success', 'Hemos enviado una nueva contraseña a su correo electrónico');
            }else{
                session()->flash('error', 'El correo indicado no corresponde a un usuario del sistema');
            }
        }else{
            session()->flash('error', 'El correo indicado no corresponde a un usuario del sistema');
        }

        return redirect()->back();
    }

    public function loginWith(Request $request) {
        $loginUser = Auth::guard('admin')->user();

        $id = $request->id;

        $user = User::where('id', '=', $id)->first();

        if(($user->enabled == 1) && ($user->lock == 0)) {

            Auth::guard('admin')->logout();
            Session::flush();

            Auth::guard('web')->loginUsingId($user->id);

            if(in_array($user->rol_id, [3,4,5,6,7,8])) {
                Audit::create([
                    'user_type' => 'Login', 
                    'user_id' => $loginUser->id, 
                    'event' => 'login', 
                    'auditable_type' => 'Login', 
                    'auditable_id' => $user->id, 
                    'old_values' => json_encode([]), 
                    'new_values' => json_encode(['login' => 'true', 'id' => $user->id, 'name' => $user->name, 'isvetegram' => 'true']), 
                    'url' => '', 
                    'ip_address' => '', 
                    'user_agent' => '', 
                    'tags' => json_encode(["id" => $loginUser->id,"name" => $loginUser->name,"lastname" => "","email" => $loginUser->email,"guard" => "Web"])
                ]);
                
                if($user->complete == 0) {
                    return redirect(route('register.complete-profile'));
                }

                return redirect(route('dash'));
            }
        }else{
            session()->flash('error', 'El usuario solicitado se encuentra inactivo o bloqueado');
            return redirect()->back();
        }
    }

    public function logout() {
        Auth::guard('admin')->logout();
        Session::flush();
        return redirect('/wpanel');
    }

}