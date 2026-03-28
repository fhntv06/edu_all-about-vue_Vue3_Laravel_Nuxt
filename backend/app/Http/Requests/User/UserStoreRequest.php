<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'nullable|date',
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
                'required' => 'Поле ":attribute" не может быть пустым!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!',
                'max' => 'Поле ":attribute" не должно превышать :max символов!',
            ],
            'author' => [
                'required' => 'Поле ":attribute" не может быть пустым!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!',
                'max' => 'Поле ":attribute" не должно превышать :max символов!',
            ],
            'content' => [
                'required' => 'Поле ":attribute" не может быть пустым!',
                'string' => 'Поле ":attribute" имеет значение с неверным типом данных!',
            ],
            'date' => [
                'date' => 'Поле ":attribute" должно быть корректной датой!',
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
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Если дата не передана, устанавливаем текущую
        if (!$this->has('date')) {
            $this->merge([
                'date' => now(),
            ]);
        }
    }
}
