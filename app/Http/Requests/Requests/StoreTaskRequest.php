<?php

namespace App\Http\Requests\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'priority' => 'required',
        ];
    }
    //This can be used for custom messages
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'description.required' => 'The description field is required.',
            'priority.required' => 'The priority field is required.',
        ];
    }
}
