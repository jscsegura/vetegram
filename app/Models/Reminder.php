<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model {

    use Searchable, SoftDeletes;

    protected $table = 'reminders';

    protected $fillable = [
        'id', 'id_user', 'section', 'to', 'to_phone', 'description', 'resume', 'date', 'email', 'sms', 'whatsapp', 'status', 'attemps', 'id_appointment',
        'id_pet', 'read', 'repeat', 'period', 'quantity', 'created_by', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'to', 'description'
    ];

    function pet() {
        return $this->hasOne('App\Models\Pet', 'id', 'id_pet')->select(['id', 'name', 'photo']);
    }

}
