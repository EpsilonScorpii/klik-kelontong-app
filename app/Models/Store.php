<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'description',
        'address',
        'phone',
        'opening_time',
        'closing_time',
        'refund_policy',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper untuk URL logo
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/default-store-logo.png');
    }

    // Helper untuk format jam operasional
    public function getOperatingHoursAttribute()
    {
        if ($this->opening_time && $this->closing_time) {
            return $this->opening_time->format('H:i') . ' - ' . $this->closing_time->format('H:i');
        }
        return 'Belum diatur';
    }
}