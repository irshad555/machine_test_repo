<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'nullable|string',
            'name' => 'required|string',
            'website' => 'nullable|string',
            'logo' => 'nullable|string',
            'size' => 'nullable|integer',
            'url' => 'nullable|max:500',
            'ext' => 'nullable|max:45',
            'thumbnail_url' => 'nullable|max:500',
            'token' => 'nullable|max:500'
            
        ];
    }
}
