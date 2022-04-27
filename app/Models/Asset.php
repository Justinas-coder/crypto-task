<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'currency',
        'crypto_currency',
        'quantity',
        'paid_value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getTotalValueAttribute()
    {
        return $this->paid_value * $this->quantity;
    }
}
