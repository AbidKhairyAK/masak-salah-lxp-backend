<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
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
        $rules = [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
        ];

        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules = [
                'course_id' => 'sometimes|required|exists:courses,id',
                'title' => 'sometimes|required|string|max:255',
            ];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'chapter title',
        ];
    }
}
