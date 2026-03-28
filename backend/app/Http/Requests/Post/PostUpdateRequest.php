<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'title' => 'string|max:255',
            'author' => 'string|max:255',
            'content' => 'string',
            'date' => 'date',
            'status' => 'in:draft,published,archived',
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
            'title' => [
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!',
                'max' => 'Поле ":attribute" не должно превышать :max символов!',
            ],
            'author' => [
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!',
                'max' => 'Поле ":attribute" не должно превышать :max символов!',
            ],
            'content' => [
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!',
            ],
            'date' => [
                'date' => 'Поле ":attribute" должно быть корректной датой!',
            ],
            'status' => [
                'in' => 'Поле ":attribute" должно быть одним из следующих значений: draft, published, archived!',
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
            'title' => 'Заголовок',
            'author' => 'Автор',
            'content' => 'Содержание',
            'date' => 'Дата',
            'status' => 'Статус',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Если нужно преобразовать данные перед валидацией
    }
}
