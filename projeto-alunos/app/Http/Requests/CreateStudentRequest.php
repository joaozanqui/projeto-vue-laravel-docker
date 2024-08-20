<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStudentRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'ra' => ['required', 'numeric', 'digits:10', Rule::unique('students', 'ra')->whereNull('deleted_at')],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', Rule::unique('students', 'email')->whereNull('deleted_at')]
        ];
    }
}
