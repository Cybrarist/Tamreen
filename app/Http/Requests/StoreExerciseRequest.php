<?php

namespace App\Http\Requests;

use App\Enum\ExerciseUnitEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExerciseRequest extends FormRequest
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
            'name' => ['string', 'required', 'max:255'],
            'unit' => ['string', 'required', Rule::enum(ExerciseUnitEnum::class)],
            'description' => ['string', 'nullable'],
            'body_parts' => ['array','nullable'],
            'body_parts.*' => ['numeric','exists:body_parts,id'],
            'images' => ['array', 'nullable'],
            'image.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5000'],
            'videos' => ['array', 'nullable'],
            'videos.*' => ['nullable', 'mimes:mp4', 'max:5000']
        ];
    }
}
