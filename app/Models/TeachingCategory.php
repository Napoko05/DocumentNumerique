<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachingCategory extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'position',
        'icon',
        'is_active',
    ];

    public function formations()
    {
        return $this->hasMany(
            Formation::class
        );
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
