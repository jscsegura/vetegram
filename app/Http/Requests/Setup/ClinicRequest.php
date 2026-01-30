<?php

namespace App\Http\Requests\Setup;

use Illuminate\Foundation\Http\FormRequest;

class ClinicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isDraft = $this->boolean('draft');

        return [
            'socialName' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'clinicname' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'idtypevet' => $isDraft ? 'nullable|integer' : 'required|integer',
            'idnumbervet' => $isDraft ? 'nullable|string|max:50' : 'required|string|max:50',
            'email_clinic' => $isDraft ? 'nullable|email|max:255' : 'required|email|max:255',
            'phone' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'website_clinic' => 'nullable|string|max:255',
            'language' => $isDraft ? 'nullable|array' : 'required|array',
            'language.*' => 'integer',
            'clinicLogo' => 'nullable|image|max:5120',
            'removeClinicLogo' => 'nullable|in:0,1',
        ];
    }
}
