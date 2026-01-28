<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ScheduleDetails extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'schedule_details';

    protected $fillable = [
        'id',
        'id_schedule',
        'day_of_week',
        'start_time',
        'end_time',
        'status',
        'created_at',
        'updated_at',
    ];

    public function generateTags(): array
    {
        return Audit::getTags();
    }

    public function getModelName()
    {
        return 'Schedule Details';
    }

    /**
     * Relation: Configuration belongs to a specific Schedule.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule');
    }
}
