<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'store_id',
        'total_amount',
        'status',
        'customer_name',
        'customer_phone',
        'customer_address',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Helper untuk format total
    public function getFormattedTotalAttribute()
    {
        return 'Rp' . number_format($this->total_amount, 0, ',', '.');
    }

    // Helper untuk badge status
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-gray-200 text-gray-800',
            'proses' => 'bg-blue-200 text-blue-800',
            'selesai' => 'bg-green-200 text-green-800',
            'dibatalkan' => 'bg-red-200 text-red-800',
            default => 'bg-gray-200 text-gray-800',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'proses' => 'Proses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => 'Unknown',
        };
    }
}
