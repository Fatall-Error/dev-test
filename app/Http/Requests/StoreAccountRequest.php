<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'website'       => 'nullable|url|max:255',
            'phone'         => 'nullable|string|min:10|max:13',
            'name'  => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Назва акаунта є обов’язковою.',
            'website.url'           => 'Введіть коректний URL.',
            'phone.min'             => 'Телефон має містити щонайменше 10 символів.',
        ];
    }
}
