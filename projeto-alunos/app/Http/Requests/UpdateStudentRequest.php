<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends ApiFormRequest
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
        $studentId = $this->route('student');

        return [
            'name' => ['string', 'max:255'],
            'ra' => ['numeric', 'digits:10', Rule::unique('students', 'ra')->whereNull('deleted_at')->ignore($studentId)],
            'email' => ['string', 'email:rfc,dns', 'max:255', Rule::unique('students', 'email')->whereNull('deleted_at')->ignore($studentId)]
        ];
    }
}
