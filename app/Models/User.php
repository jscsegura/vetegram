<?php

namespace App\Models;

use App\Console\Commands\sendNotifieds;
use App\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable {

    use Notifiable, Searchable, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'users';

    protected $fillable = [
        'id', 'id_vet', 'type_dni', 'dni', 'name', 'lastname', 'email', 'country', 'province', 'canton', 'district', 
        'phone', 'code', 'email_verified_at', 'password', 'rol_id', 'facebook', 'google', 'photo', 'last_login', 
        'rate', 'pro', 'enabled', 'lock', 'complete', 'mode', 'process', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'name', 'lastname', 'email'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $auditExclude = [
        'password', 'last_login', 'process', 'updated_at'
    ];
    
    public function generateTags(): array {
        return Audit::getTags();
    }

    public function getModelName() {
        return 'Usuarios';
    }

    public function sendPasswordResetNotification($token)
    {
        $email = $this->attributes['email'];
        $subject = trans('auth.reset.password.subject');

        $data = ['token' => $token, 'email' => $email];
        $template = view('emails.general.reset_password', $data)->render();

        $row = Notifications::create([
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
    }

    public static function encryptor($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";

        $secret_key = 'vtgrmv1';
        $secret_iv = 'vtgrmv1flc';

        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public function getPets () {
        return $this->hasMany(Pet::class, 'id_user', 'id');
    }

    public function getVet () {
        return $this->hasOne('App\Models\Vets', 'id', 'id_vet')->select(['id', 'company', 'country', 'province', 'canton', 'district', 'address', 'pro', 'expire']);
    }

}
