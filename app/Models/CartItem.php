<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper untuk subtotal
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }
}