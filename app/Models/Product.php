<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Champs autorisés à l’insertion
    protected $fillable = [
        'name',
        'price',
        'description',
        'is_active',
    ];

    // Casts (sécurité et confort)
    protected $casts = [
        'price' => 'integer',
        'is_active' => 'boolean',
    ];
}
