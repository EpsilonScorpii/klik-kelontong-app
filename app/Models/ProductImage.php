<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper untuk URL gambar
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}