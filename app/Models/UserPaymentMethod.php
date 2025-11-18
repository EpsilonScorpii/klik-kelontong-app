<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class UserPaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'card_type',
        'card_holder_name',
        'card_number',
        'card_last_four',
        'expiry_date',
        'cvv',
        'ewallet_provider',
        'ewallet_account',
        'is_linked',
        'is_default',
    ];

    protected $casts = [
        'is_linked' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected $hidden = [
        'card_number',
        'cvv',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Encrypt card number before saving
    public function setCardNumberAttribute($value)
    {
        if ($value) {
            $this->attributes['card_number'] = Crypt::encryptString($value);
            $this->attributes['card_last_four'] = substr($value, -4);
        }
    }

    // Decrypt card number when reading
    public function getCardNumberAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    // Helper untuk masked card number
    public function getMaskedCardNumberAttribute()
    {
        return '•••• •••• •••• ' . $this->card_last_four;
    }

    // Helper untuk display name
    public function getDisplayNameAttribute()
    {
        if ($this->type === 'card') {
            return strtoupper($this->card_type ?? 'Card') . ' •••• ' . $this->card_last_four;
        } else {
            return ucfirst($this->ewallet_provider);
        }
    }

    // Boot method untuk handle default payment
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($method) {
            if ($method->is_default) {
                // Unset other default methods for this user
                static::where('user_id', $method->user_id)
                     ->where('id', '!=', $method->id)
                     ->update(['is_default' => false]);
            }
        });
    }
}