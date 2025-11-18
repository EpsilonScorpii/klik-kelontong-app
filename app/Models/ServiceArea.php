<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'area_name',
        'city',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}