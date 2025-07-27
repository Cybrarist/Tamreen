<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Numeric;

class UpdateWorkoutRequest extends FormRequest
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
            'exercises' => ['array' , 'required'],
            'exercises.*.id' => ['required', 'numeric', 'exists:exercises,id'],
            'exercises.*.count' => ['required', 'numeric' , 'integer', 'min:0'],
            'exercises.*.multiplier' => ['required', 'numeric' , 'min:0'],
            'exercises.*.completed' => ['nullable', 'numeric' , 'integer', 'min:0'],
        ];
    }
}
