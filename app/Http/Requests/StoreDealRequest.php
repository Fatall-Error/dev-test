<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDealRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'stage' => 'required',
            'account_id' => 'required',
            'name' => 'required|string|max:255',
            'closing_date' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Назва Угоди є обов’язковою.',
            'stage.required' => 'Стадія угоди є обов’язковою.',
            'account_id.required' => 'Виберіть Аккаунт зі списку або створіть новий.',
            'closing_date.required' => 'Дата угоди є обов’язковою.',
        ];
    }
}
