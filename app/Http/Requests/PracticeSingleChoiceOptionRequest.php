<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PracticeSingleChoiceOptionRequest extends FormRequest
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
            'removed_items' => 'array',
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.question_id' => 'required|integer',
            'items.*.description' => 'required|string',
            'items.*.is_correct' => 'boolean',
  
        ];
    }
}
