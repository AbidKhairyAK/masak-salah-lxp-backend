<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'instructor_id' => 'required|exists:instructors,id',
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules = [
                'instructor_id' => 'sometimes|required|exists:instructors,id',
                'title' => 'sometimes|required|string|max:255',
                'caption' => 'sometimes|required|string',
                'description' => 'sometimes|required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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
            'title'         => 'course title',
            'instructor_id' => 'instructor',
            'image'         => 'course image',
        ];
    }
}
