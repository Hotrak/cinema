<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' =>'required|unique:users|email',
            'password' =>'required|min:6|max:40|confirmed ',
            'phone' =>'required',
            'name' =>'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email является обязательным для заполнения',
            'email.email' => 'Email является обязательным для заполнения',
            'phone.required' => 'Телефон является обязательным для заполнения',
            'name.required' => 'Имя является обязательным для заполнения',
            'password.required'  => 'Пароль является обязательным для заполнения',
            'email.unique' => 'Пользователь с данным Email уже зарегистрирован',
            'password.confirmed'  => 'Пароли не совподяют',
            'password.min'  => 'Пароль слишком лёгкий',
            'password.max'  => 'Пароль слишком длинный',
        ];
    }
}
