<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'phone',
        'email',
        'address',
        'loyalty_points',
        'cashback_balance',
        'total_orders',
        'total_spent',
        'is_active',
    ];

    protected $casts = [
        'loyalty_points' => 'decimal:2',
        'cashback_balance' => 'decimal:2',
        'total_spent' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relasi
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper untuk format cashback
    public function getFormattedCashbackAttribute()
    {
        return 'Rp' . number_format($this->cashback_balance, 0, ',', '.');
    }

    // Helper untuk format total spent
    public function getFormattedTotalSpentAttribute()
    {
        return 'Rp' . number_format($this->total_spent, 0, ',', '.');
    }
}