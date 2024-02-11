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
            'title' => 'required|string|max:255',
            'description' => 'string|max:255',
            'status' => 'string|max:255',
            'completed' => 'boolean',
            'user_id' => 'required|exists:users,id',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')){
            $rules['title'] = 'sometimes|string|max:255';
            $rules['user_id'] = 'sometimes|exists:users,id';
        }

        return $rules;
    }
}