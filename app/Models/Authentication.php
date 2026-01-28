<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authentication extends Model {
    
    protected  $primaryKey = 'token';
    
    public static function validToken($token = "", $expire = false) {
        $data = ['error' => '', 'valid' => 0, 'user_id' => 0];

        $auth = Authentication::select('id', 'expire', 'id_user')->where('token', '=', $token)->first();
        
        if(isset($auth->id)) {
            $now = date('Y-m-d H:i:s');

            if(strtotime($now) <= strtotime($auth->expire)) {
                $data['error']   = '';
                $data['valid']   = 1;
                $data['user_id'] = $auth->id_user;

                if($expire == true) {
                    $auth->expire = Authentication::setTimeSession();
                    $auth->update();
                }
            }else{
                $data['error'] = "The token has expired";
            }
        }else{
            $data['error'] = "Unauthorized";
        }

        return $data;
    }
    
    public static function setTimeSession() {
        $now = date('Y-m-d H:i:s');
        $future = strtotime('+1 week', strtotime($now));
        return date('Y-m-d H:i:s', $future);
    }
    
}