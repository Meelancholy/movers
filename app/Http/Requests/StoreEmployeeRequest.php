<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:employees',
            'department' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'bdate' => 'required|date',
            'job_type' => 'required|string|max:20',
            'gender' => 'required|string|max:10',
            'status' => 'required|string|max:20',
            'contact' => 'required|string|max:20',
        ];
    }
}
