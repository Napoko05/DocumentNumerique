<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;


    protected $fillable = [

        'name',
        'slug',
        'is_active',

    ];


    protected $casts = [

        'is_active' => 'boolean',

    ];

    public function documents()
    {
        return $this->belongsToMany(
            Document::class
        );
    }
    public function scopeActive($query)
    {
        return $query->where(
            'is_active',
            true
        );
    }
}