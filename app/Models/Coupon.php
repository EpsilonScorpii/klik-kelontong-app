<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'code',
        'name',
        'description',
        'type', // percentage, fixed_amount, free_delivery
        'value',
        'min_purchase',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    // Check if coupon is valid
    public function isValid()
    {
        return $this->is_active 
            && $this->start_date <= now() 
            && $this->end_date >= now()
            && $this->used_count < $this->usage_limit;
    }

    // Get discount amount
    public function getDiscountAmount($subtotal)
    {
        if ($this->type === 'percentage') {
            return ($subtotal * $this->value) / 100;
        } elseif ($this->type === 'fixed_amount') {
            return $this->value;
        } elseif ($this->type === 'free_delivery') {
            return $this->value; // delivery fee amount
        }
        return 0;
    }
}