<?php

namespace App\Http\Requests\Setup;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'schedule' => 'nullable|array',
            'schedule.*' => 'nullable|array',
            'schedule.*.*.from' => 'nullable|string',
            'schedule.*.*.to' => 'nullable|string',
        ];
    }
}
