<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    // Tambahkan 'product_name' ke fillable
    protected $fillable = [
        'product_id',
        'product_name',
        'user_id',
        'price',
        'quantity',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
        return $this->belongsTo(\App\Models\User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}