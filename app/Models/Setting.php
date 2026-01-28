<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Setting extends Model implements Auditable {

    use \OwenIt\Auditing\Auditable;

    protected $table = 'settings';

    protected $fillable = [
        'id', 'email_host', 'email_user', 'email_pass', 'email_port', 'email_from', 'email_tls', 'email_to', 
        'google_id', 'google_secret', 'facebook_id', 'facebook_secret', 'facebook_version', 'term_es', 'term_en', 
        'user_invoice', 'pass_invoice', 'environment_invoice', 'max_appointment_free', 'max_user_free', 'max_storage_free', 
        'max_appointment_pro', 'max_user_pro', 'max_storage_pro', 'price_pro', 'tilopay_key', 'tilopay_user', 'tilopay_pass', 'created_at', 'updated_at'
    ];

    public static function getEmailSetting() {
        $setting = Setting::select('id', 'email_host', 'email_user', 'email_pass', 'email_port', 'email_from', 'email_tls', 'email_to')->where('id', '=', 1)->first();

        if(!isset($setting->id)) {
            $setting = Setting::setDefault();
        }

        return $setting;
    }

    public static function getSocialSetting() {
        $setting = Setting::select('id', 'google_id', 'google_secret', 'facebook_id', 'facebook_secret')->where('id', '=', 1)->first();

        if(!isset($setting->id)) {
            $setting = Setting::setDefault();
        }

        return $setting;
    }
    
    public static function getLimitsSetting() {
        $setting = Setting::select('id', 'max_appointment_free', 'max_user_free', 'max_storage_free', 'max_appointment_pro', 'max_user_pro', 'max_storage_pro', 'price_pro')->where('id', '=', 1)->first();

        if(!isset($setting->id)) {
            $setting = Setting::setDefault();
        }

        return $setting;
    }

    public static function getTilopaySetting() {
        $setting = Setting::select('id', 'tilopay_key', 'tilopay_user', 'tilopay_pass', 'price_pro')->where('id', '=', 1)->first();

        if(!isset($setting->id)) {
            $setting = Setting::setDefault();
        }

        return $setting;
    }

    public static function setDefault() {
        $setting = Setting::create([
            'id' => 1,
            'email_host' => '',
            'email_user' => '', 
            'email_pass' => '', 
            'email_port' => '', 
            'email_from' => '', 
            'email_tls' => '',
            'google_id' => '', 
            'google_secret' => '', 
            'facebook_id' => '', 
            'facebook_secret' => '', 
            'term_es' => '',
            'term_en' => '',
            'user_invoice' => '',
            'pass_invoice' => '',
            'environment_invoice' => 0,
            'max_appointment_free' => 0,
            'max_user_free' => 0, 
            'max_storage_free' => 0,
            'max_appointment_pro' => 0,
            'max_user_pro' => 0,
            'max_storage_pro' => 0,
            'price_pro' => 0,
            'tilopay_key' => '',
            'tilopay_user' => '',
            'tilopay_pass' => ''
        ]);

        return $setting;
    }

    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Configuracion';
    }

}
