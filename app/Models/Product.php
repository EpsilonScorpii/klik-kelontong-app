<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'total_sales',
        'min_stock',
        'unit',
        'barcode',
        'image',
        'images',
        'weight',
        'is_active',
    ];

    protected $attributes = [
        'discount_price' => 0.0,
        'stock' => 0,
        'is_active' => true,
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
        'images' => 'array', // ✅ Cast images JSON ke array
    ];

    // ✅ Relasi ke Store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // ✅ Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ✅ Relasi ke Product Images (jika punya tabel terpisah)
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    // ✅ Alias untuk relasi images (agar bisa dipanggil ->images)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // ✅ Relasi ke Cart Items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // ✅ Relasi ke Order Items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ✅ Relasi ke Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper untuk URL gambar utama
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }

    // Helper untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDiscountPriceAttribute()
    {
        return 'Rp' . number_format($this->discount_price, 0, ',', '.');
    }

    // Helper untuk discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price > 0 && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    // Helper untuk check stok
    public function isLowStock()
    {
        return $this->stock <= $this->min_stock;
    }

    public function isOutOfStock()
    {
        return $this->stock <= 0;
    }

    // Boot method untuk auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
