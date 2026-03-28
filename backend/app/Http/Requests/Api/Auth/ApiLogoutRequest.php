<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ApiLogoutRequest extends FormRequest
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
        return [
            'email' => 'required|string|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/|max:255',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email' => [
                'required' => 'Поле ":attribute" не может быть пустым!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!',
                'regex' => 'Поле ":attribute" должно быть корректным email адресом!',
                'max' => 'Поле ":attribute" не должно превышать :max символов!',
            ],
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
            'email' => 'Email',
        ];
    }
}
