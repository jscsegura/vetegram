<?php

namespace App\Http\Requests\Setup;

use Illuminate\Foundation\Http\FormRequest;

class SpecialtiesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isDraft = $this->boolean('draft');

        return [
            'species' => $isDraft ? 'nullable|array' : 'required|array',
            'species.*' => 'integer',
            'specialty' => 'nullable|array',
            'specialty.*' => 'integer',
            'services' => 'nullable|array',
            'services.*' => 'integer',
        ];
    }
}
