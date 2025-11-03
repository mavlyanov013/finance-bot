<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'category_id' => 'sometimes|exists:categories,id',
            'currency_id' => 'sometimes|exists:currencies,id',
            'amount' => 'sometimes|numeric|min:0.01',
            'date' => 'sometimes|date',
            'note' => 'nullable|string|max:500',
        ];
    }
}
