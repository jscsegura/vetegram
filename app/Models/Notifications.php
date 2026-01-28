<?php

namespace App\Models;

use App\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model {

    use Searchable, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'id', 'id_user', 'to', 'subject', 'description', 'attach', 'email', 'sms', 'whatsapp', 'status', 'attemps', 'created_at', 'updated_at'
    ];

    public $searchable = [
        'id', 'to', 'subject'
    ];
}
