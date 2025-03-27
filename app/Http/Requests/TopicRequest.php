<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
            'chapter_id' => 'required|exists:chapters,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:lesson,practice',
            'sort_order' => 'sometimes|integer|min:1',
            
            // For child model creation, these are optional in API
            'children_type' => 'sometimes|string',
            'leave_after_submit' => 'sometimes|boolean'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'topic title',
            'type' => 'topic type',
            'children_type' => 'lesson or practice type',
            'sort_order' => 'display order'
        ];
    }
}
