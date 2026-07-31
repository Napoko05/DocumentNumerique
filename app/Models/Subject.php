<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;


    protected $fillable = [

        'level_id',
        'name',
        'slug',
        'is_active',

    ];



    protected $casts = [

        'is_active' => 'boolean',

    ];



    /*
    |--------------------------------------------------------------------------
    | NIVEAU CONCERNE
    |--------------------------------------------------------------------------
    */

    public function level()
    {
        return $this->belongsTo(Level::class);
    }



    /*
    |--------------------------------------------------------------------------
    | DOCUMENTS
    |--------------------------------------------------------------------------
    */

    public function documents()
    {
        return $this->hasMany(Document::class);
    }



    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}