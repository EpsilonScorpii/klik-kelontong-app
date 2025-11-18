<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'label',
        'value',
        'icon',
        'url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}