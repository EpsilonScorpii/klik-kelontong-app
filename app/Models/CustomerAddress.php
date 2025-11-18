<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'recipient_phone',
        'address',
        'latitude',
        'longitude',
        'is_default',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_default' => 'boolean',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper untuk format alamat lengkap
    public function getFullAddressAttribute()
    {
        return $this->address;
    }

    // Helper untuk format kontak
    public function getContactInfoAttribute()
    {
        return $this->recipient_name . ' (' . $this->recipient_phone . ')';
    }

    // Boot method untuk handle default address
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($address) {
            if ($address->is_default) {
                // Unset other default addresses for this user
                static::where('user_id', $address->user_id)
                     ->where('id', '!=', $address->id)
                     ->update(['is_default' => false]);
            }
        });
    }
}