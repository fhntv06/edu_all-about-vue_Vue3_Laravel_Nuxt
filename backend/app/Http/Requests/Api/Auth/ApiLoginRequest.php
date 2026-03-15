<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ApiLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/|max:255',
            'password' => 'required|string|min:8|max:255',
            'rememberMe' => 'bool'
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
            'password' => [
                'required' => 'Поле ":attribute" не может быть пустым!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!',
                'min' => 'Поле ":attribute" должно содержать минимум :min символов!',
                'max' => 'Поле ":attribute" не должно превышать :max символов!',
            ],
            'rememberMe' => [
                'bool' => 'Поле ":attribute" имеет значение с неверным типом данных!'
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
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }
}
