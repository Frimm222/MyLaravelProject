<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route()->parameter('user');

        return [
            'name' => [
                'required',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => [
                'nullable',
                'min:8',
            ],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function messages(): array
    {
        return [
            // Сообщения для поля name
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.max' => 'Имя не может быть длиннее 255 символов.',

            // Сообщения для поля email
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.max' => 'Email не может быть длиннее 255 символов.',
            'email.unique' => 'Пользователь с таким email уже зарегистрирован.',

            // Сообщения для поля password
            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ];
    }
}
