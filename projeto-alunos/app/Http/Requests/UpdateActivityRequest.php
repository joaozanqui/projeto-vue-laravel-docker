<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateActivityRequest extends ApiFormRequest
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
        $activityId = $this->route('activity');

        return [
            'name' => ['string', 'max:255', Rule::unique('activities', 'name')->whereNull('deleted_at')->ignore($activityId)],
            'description' => ['string', 'max:1023']
        ];
    }
}
