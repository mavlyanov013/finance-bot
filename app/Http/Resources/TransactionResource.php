<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'date' => $this->date->format('Y-m-d'),
            'note' => $this->note,
            'user' => $this->user->name ?? 'Noma’lum foydalanuvchi',
            'category' => $this->category->name ?? 'Noma’lum kategoriya',
            'currency' => $this->currency->code ?? 'USD',
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
