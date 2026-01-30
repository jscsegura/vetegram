<?php

namespace App\Http\Requests\Setup;

use Illuminate\Foundation\Http\FormRequest;

class IdentityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isDraft = $this->boolean('draft');

        return [
            'idtype' => $isDraft ? 'nullable|integer' : 'required|integer',
            'idnumber' => $isDraft ? 'nullable|string|max:50' : 'required|string|max:50',
            'mycode' => $isDraft ? 'nullable|in:1,2' : 'required|in:1,2',
            'vcode' => ($isDraft ? 'nullable' : 'required_if:mycode,1') . '|string|max:50',
            'profilePhoto' => 'nullable|image|max:5120',
            'removeProfilePhoto' => 'nullable|in:0,1',
        ];
    }
}
