<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccessCodeRequest extends FormRequest
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
        $access_code_id = $this->route('access_code')?->id;

        return [
            'course_id'     => 'required|exists:App\Models\Course,id',
            'title'         => [
                'required', 'max:255',
                Rule::unique('\App\Models\AccessCode')->ignore($access_code_id)
            ],
            'code'          => [
                'required', 'min:5', 'max:10',
                Rule::unique('\App\Models\AccessCode')->ignore($access_code_id)
            ],
            'quota_total'   => 'required|max:65535|numeric|gt:0',
            'expiry_date'   => 'required|after_or_equal:today',
        ];
    }
}
