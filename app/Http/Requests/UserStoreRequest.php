<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
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
