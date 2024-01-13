<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email	' => 'nullable|string',
            'phone' =>  'nullable|regex:/^\+[0-9]{1,3}[0-9]{5,14}$/',
            'company_id' => "nullable|integer|exists:" . Company::getTableName() . ",id",
        ];
    }
}
