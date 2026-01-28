<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller {
    
    public function sendResetLink(Request $request) {
        
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === Password::RESET_LINK_SENT) {
            if(isset($request->ajax)) {
                return response()->json(['type' => 'success', 'status' => trans($status, [], 'es')], 200);
            }else{
                session()->flash('success', trans($status));
                return redirect()->back();
            }
        }else{
            if(isset($request->ajax)) {
                return response()->json(['type' => 'error', 'status' => trans($status, [], 'es')], 200);
            }else{
                session()->flash('error', trans($status));
                return redirect()->back();
            }
        }
    }

    public function reset(Request $request) {
        return view('auth.reset-password', ['token' => $request->token, 'email' => $request->email]);
    }

    public function update(Request $request) {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'enabled' => 1,
                    'email_verified_at' => date('Y-m-d H:i:s')
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET) {
            session()->flash('success', trans($status));
            return redirect()->route('home.index');
        }else{
            session()->flash('error', trans($status));
            return redirect()->back();
        }        
    }

}
