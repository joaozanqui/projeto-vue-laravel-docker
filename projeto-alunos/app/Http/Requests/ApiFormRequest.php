<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
// use Validator;

class ApiFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * Handle a failed validation attempt.
     * 
     * @param Validator $validator
     * @return void
     */

    protected function failedValidation(Validator $validator) {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['erros' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
