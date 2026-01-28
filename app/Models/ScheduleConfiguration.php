<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ScheduleConfiguration extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'schedule_configurations';

    protected $fillable = [
        'id',
        'id_schedule',
        'min_time_from_today',
        'max_time_from_today',
        'time_between_slots',
        'time_before_appointment',
        'time_after_appointment',
        'procedure_break_time',
        'daily_appointment_limit',
        'created_at',
        'updated_at',
    ];

    public function generateTags(): array
    {
        return Audit::getTags();
    }

    public function getModelName()
    {
        return 'Schedule Configuration';
    }

    /**
     * Relation: Configuration belongs to a specific Schedule.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule');
    }
}
