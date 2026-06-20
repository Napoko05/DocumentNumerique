<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'title',
        'description',
        'content',
        'category',
        'level',
        'cycle',
        'file_path',
        'cover_image',
        'access_type',
        'price',
        'status',
        'views'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}