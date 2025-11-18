<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'bank_name',
        'account_number',
        'account_holder',
        'amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}