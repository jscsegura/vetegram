<?php

namespace App\Http\Requests\Setup;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isDraft = $this->boolean('draft');
        $country = $this->input('country');
        $isCR = (string) $country === '53';

        return [
            'country' => $isDraft ? 'nullable|integer' : 'required|integer',
            'province' => $isCR ? ($isDraft ? 'nullable' : 'required') : 'nullable',
            'canton' => $isCR ? ($isDraft ? 'nullable' : 'required') : 'nullable',
            'district' => $isCR ? ($isDraft ? 'nullable' : 'required') : 'nullable',
            'province_alternate' => !$isCR ? ($isDraft ? 'nullable|string|max:255' : 'required|string|max:255') : 'nullable|string|max:255',
            'canton_alternate' => !$isCR ? ($isDraft ? 'nullable|string|max:255' : 'required|string|max:255') : 'nullable|string|max:255',
            'vetaddress' => $isDraft ? 'nullable|string' : 'required|string',
            'lat' => $isDraft ? 'nullable|numeric' : 'required|numeric',
            'lng' => $isDraft ? 'nullable|numeric' : 'required|numeric',
        ];
    }
}
