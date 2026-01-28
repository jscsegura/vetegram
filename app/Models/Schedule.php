<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\ScheduleDetails;
use App\Models\ScheduleConfiguration;
use App\Models\ScheduleExtraSlots;
use App\Models\ScheduleExceptions;

class Schedule extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'schedule';

    protected $fillable = [
        'id',
        'id_user',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];

    

    public function generateTags(): array
    {
        return Audit::getTags();
    }

    public function getModelName()
    {
        return 'Schedule';
    }

    /**
     * Relation: A schedule belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relation: A schedule has many schedule details.
     */
    public function scheduleDetails()
    {
        return $this->hasMany(ScheduleDetails::class, 'id_schedule');
    }

    /**
     * Relation: A schedule has one configuration.
     */
    public function scheduleConfiguration()
    {
        return $this->hasOne(ScheduleConfiguration::class, 'id_schedule');
    }
    /**
     * Relation: A schedule has many extra slots.
     */
    public function scheduleExtraSlots()
    {
        return $this->hasMany(ScheduleExtraSlots::class, 'id_schedule');
    }
    /**
     * Relation: A schedule has many exceptions.
     */
    public function scheduleExceptions()
    {
        return $this->hasMany(ScheduleExceptions::class, 'id_schedule');
    }

}
