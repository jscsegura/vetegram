<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SettingPro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller {

    public function __construct() {}
    
    public function index() {
        $setting = Setting::where('id', '=', 1)->first();

        if(!isset($setting->id)) {
            $setting = Setting::setDefault();
        }

        return view('wpanel.setting.index', compact('setting'));
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $setting = Setting::where('id', '=', $id)->first();

            $setting->email_host      = $request->email_host;
            $setting->email_user      = $request->email_user;
            $setting->email_pass      = $request->email_pass;
            $setting->email_port      = $request->email_port;
            $setting->email_from      = $request->email_from;
            $setting->email_tls       = $request->email_tls;
            $setting->email_to        = $request->email_to;
            $setting->google_id       = $request->google_id;
            $setting->google_secret   = $request->google_secret;
            $setting->facebook_id     = $request->facebook_id;
            $setting->facebook_secret = $request->facebook_secret;
            $setting->term_es        = str_replace("\\", "",$request->term_es);
            $setting->term_en        = str_replace("\\", "",$request->term_en);
            $setting->user_invoice   = $request->user_invoice;
            $setting->pass_invoice   = $request->pass_invoice;
            $setting->environment_invoice = $request->environment_invoice;

            $setting->max_appointment_free = $request->max_appointment_free;
            $setting->max_user_free = $request->max_user_free;
            $setting->max_storage_free = $request->max_storage_free;
            $setting->max_appointment_pro = $request->max_appointment_pro;
            $setting->max_user_pro = $request->max_user_pro;
            $setting->max_storage_pro = $request->max_storage_pro;
            $setting->price_pro = $request->price_pro;

            $setting->tilopay_key  = $request->tilopay_key;
            $setting->tilopay_user = $request->tilopay_user;
            $setting->tilopay_pass = $request->tilopay_pass;

            $setting->update();

            session()->flash('success', 'Configuración actualizada exitosamente!');

            return redirect(route('wp.settings.index'));
        }
    }

    public function pro() {
        $pros = SettingPro::orderBy('pro', 'desc')->get();

        return view('wpanel.setting.pro', compact('pros'));
    }

    public function proCreate() {
        return view('wpanel.setting.pro-create');
    }

    public function proStore(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $service = new SettingPro();
            $service->title_es = $request->title_es;
            $service->title_en = $request->title_en;
            $service->pro = $request->pro;
            $service->enabled = 1;
            $service->save();

            session()->flash('success', 'Rubro creado exitosamente!');

            return redirect(route('wp.setting.pro'));
        }
        die;
    }

    public function proEdit(Request $request) {
        $id = $request->id;

        if (Auth::guard('admin')->user()->rol_id == 1) {
            $rubro = SettingPro::where('id', '=', $id)->first();
            
            return view('wpanel.setting.pro-edit', compact('rubro'));
        }
    }

    public function proUpdate(Request $request) {
        $id = $request->id;

        if (Auth::guard('admin')->user()->rol_id == 1) {
            $rubro = SettingPro::where('id', '=', $id)->first();

            $rubro->title_es = $request->title_es;
            $rubro->title_en = $request->title_en;
            $rubro->pro = $request->pro;
            $rubro->update();

            session()->flash('success', 'Rubro actualizado exitosamente!');

            return redirect(route('wp.setting.pro'));
        }
    }

    public function proEnabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $rubro = SettingPro::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($rubro->id)) {
                if($rubro->enabled == 1) {
                    $rubro->enabled = 0;
                    $rubro->update();
                    $enabled = 0;
                }else{
                    $rubro->enabled = 1;
                    $rubro->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function proDelete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            SettingPro::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

}