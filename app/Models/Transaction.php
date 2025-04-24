<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    // ✅ Sudah lengkap termasuk 'status'
    protected $fillable = [
        'product_id',
        'product_name',
        'user_id',
        'price',
        'quantity',
        'total_price',
        'status',
    ];

    // ✅ Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Relasi ke product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ✅ Relasi ke transaction item kalau ada
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}