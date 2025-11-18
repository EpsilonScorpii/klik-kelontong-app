<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'email_verified_at',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    // Relasi ke Store
    public function store()
    {
        return $this->hasOne(Store::class, 'user_id');
    }

    // Relasi ke Cart Items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // ✅ Relasi ke Customer Addresses
    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    // ✅ Relasi ke Default Address
    public function defaultAddress()
    {
        return $this->hasOne(CustomerAddress::class)->where('is_default', true);
    }

    // Relasi ke Payment Methods
    public function paymentMethods()
    {
        return $this->hasMany(UserPaymentMethod::class);
    }

    // Relasi ke Default Payment Method
    public function defaultPaymentMethod()
    {
        return $this->hasOne(UserPaymentMethod::class)->where('is_default', true);
    }

    // Helper untuk hitung total cart items
    public function getCartItemsCountAttribute()
    {
        return $this->cartItems()->sum('quantity');
    }

    // Helper untuk hitung total harga cart
    public function getCartTotalAttribute()
    {
        return $this->cartItems()->get()->sum('subtotal');
    }

    // Relasi lainnya
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
