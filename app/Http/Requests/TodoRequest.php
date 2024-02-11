<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'string|max:255',
            'staus' => 'string|max:255',
            'completed' => 'boolean'
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')){
            $rules['title'] = 'sometimes|string|max:255';
        }
        
        return $rules;
    }
}
