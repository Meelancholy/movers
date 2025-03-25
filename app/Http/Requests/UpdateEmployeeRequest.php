<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|string|max:50',
            'last_name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|unique:employees,email,'.$this->employee->id,
            'department' => 'sometimes|string|max:50',
            'position' => 'sometimes|string|max:50',
            'bdate' => 'sometimes|date',
            'job_type' => 'sometimes|string|max:20',
            'gender' => 'sometimes|string|max:10',
            'status' => 'sometimes|string|max:20',
            'contact' => 'sometimes|string|max:20',
        ];
    }
}
