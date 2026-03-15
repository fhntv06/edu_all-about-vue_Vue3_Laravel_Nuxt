<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ApiRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
            'login' => 'required|string|max:255|regex:/^[a-zA-Z0-9_]+$/|unique:users',
            'email' => 'required|string|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/|max:255|unique:users',
            'phone' => 'string|min:11|max:16|regex:/^\+?[78][-\(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}$/|unique:users',
            'password' => 'required|string|min:8|max:255',
            'privacyAccepted' => 'required|bool'
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
            'firstname' => [
                'required' => 'Поле ":attribute" обязательно для заполнения!',
                'regex' => 'Поле ":attribute" должно содержать только буквы латинского алфавита!',
                'max' => 'Поле ":attribute" имеет слишком длинное значение!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!'
            ],
            'login' => [
                'required' => 'Поле ":attribute" обязательно для заполнения!',
                'unique' => 'Поле ":attribute" с таким значением уже существует!',
                'regex' => 'Поле ":attribute" должно содержать только буквы латинского алфавита, цифры или знак "_"!',
                'max' => 'Поле ":attribute" имеет слишком длинное значение!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!'
            ],
            'email' => [
                'required' => 'Поле ":attribute" обязательно для заполнения!',
                'unique' => 'Поле ":attribute" с таким значением уже существует!',
                'regex' => 'Поле ":attribute" имеет не корректное значение!',
                'max' => 'Поле ":attribute" имеет слишком длинное значение!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!'
            ],
            'phone' => [
                'unique' => 'Поле ":attribute" с таким значением уже существует!',
                'regex' => 'Поле ":attribute" имеет не корректный формат!',
                'min' => 'Поле ":attribute" имеет слишком короткое значение!',
                'max' => 'Поле ":attribute" имеет слишком длинное значение!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!'
            ],
            'password' => [
                'required' => 'Поле ":attribute" обязательно для заполнения!',
                'min' => 'Поле ":attribute" должно содержать минимум 8 символов!',
                'max' => 'Поле ":attribute" имеет слишком длинное значение!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!'
            ],
            'privacyAccepted' => [
                'required' => 'Поле ":attribute" обязательно для заполнения!',
                'bool' => 'Поле ":attribute" имеет значение с неверным типом данных!'
            ]
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
            'firstname' => 'Имя',
            'login' => 'Логин',
            'phone' => 'Телефон',
            'email' => 'Email',
            'password' => 'Пароль',
            'privacyAccepted' => 'Согласие на обработку персональных данных'
        ];
    }
}
