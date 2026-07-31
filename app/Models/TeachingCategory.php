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
        'icon',
        'is_active',
    ];

    public function formations()
    {
        return $this->hasMany(
            Formation::class
        );
    }

}