<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ScheduleExceptions extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'schedule_exceptions';
    protected $fillable = [
        'id',
        'id_schedule',
        'description',
        'date',
        'start_time',
        'end_time',
        'reason',
        'is_all_day',
        'created_at',
        'updated_at',
    ];

    public function generateTags(): array
    {
        return Audit::getTags();
    }

    public function getModelName()
    {
        return 'Schedule Exceptions';
    }

    /**
     * Relation: Configuration belongs to a specific Schedule.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule');
    }
}
