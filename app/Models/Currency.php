<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'rate',
    ];

    /**
     * Shu valyuta orqali amalga oshirilgan transactionlar.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
