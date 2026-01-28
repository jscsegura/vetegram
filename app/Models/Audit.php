<?php

namespace App\Models;

use App\Searchable;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model {

    use Searchable;
    
    protected $table = 'audits';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'user_type', 'user_id', 'event', 'auditable_type', 'auditable_id', 'old_values',
        'new_values', 'url', 'ip_address', 'user_agent', 'tags', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'user_type', 'user_id', 'event', 'auditable_type', 'auditable_id', 'old_values',
        'new_values', 'url', 'ip_address', 'user_agent', 'tags', 'created_at', 'updated_at'
    ];

    public static function getTags() {
        $tags = '';

        $authWeb = auth()->guard('web')->user();
        $authAdmin = auth()->guard('admin')->user();

        if($authWeb != null) {
            $tags = json_encode(["id"=>$authWeb->id, "name"=>$authWeb->name, "lastname"=>$authWeb->lastname, "email"=>$authWeb->email, "guard"=>"Web"]);
        }elseif($authAdmin != null) {
            $tags = json_encode(["id"=>$authAdmin->id, "name"=>$authAdmin->name, "lastname"=>$authAdmin->lastname, "email"=>$authAdmin->email, "guard"=>"Admin"]);
        }else{
            $tags = json_encode(["id"=>"", "name"=>"", "lastname"=>"", "email"=>"", "guard"=>"Guest"]);
        }

        return [$tags];
    }

}
