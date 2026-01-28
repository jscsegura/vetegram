<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.home.index');
    }

    public function profile() {
        $user = Auth::guard('admin')->user();
        return view('wpanel.home.profile', compact('user'));
    }

    public function profileUpdate(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $user = Auth::guard('admin')->user();

            $profile = User::where('id', '=', $user->id)->first();

            $profile->name     = $request->name;
            $profile->lastname = $request->lastname;
        
            if(($request->txtPassword != '')&&($request->txtPassword == $request->txtPasswordConfirm)) {
                $profile->password = Hash::make($request->txtPassword);
            }

            $profile->update();

            if(isset($request->photo)) {
                $imageName = uniqid().time().'.'.$request->photo->extension();
                if($request->photo->move(public_path('files/user/image'), $imageName)) {
                    $profile->photo = $imageName;
                    $profile->update();
                }
            }

            session()->flash('success', 'Usuario actualizado exitosamente!');

            return redirect(route('wp.home.profile'));
        }
    }

}