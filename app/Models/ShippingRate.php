<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'distance_from',
        'distance_to',
        'cost',
        'label',
        'is_active',
    ];

    protected $casts = [
        'distance_from' => 'decimal:2',
        'distance_to' => 'decimal:2',
        'cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function getFormattedCostAttribute()
    {
        return 'Rp' . number_format($this->cost, 0, ',', '.');
    }
}