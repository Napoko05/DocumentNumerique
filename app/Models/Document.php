<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Staff;
use App\Models\User;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'title',
        'description',
        'content',
        'type',
        'access_type',
        'price',
        'views',
        'level',
        'classe',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function buyers()
    {
        return $this->belongsToMany(
            User::class,
            'document_user',
            'document_id',
            'user_id'
        )->withTimestamps();
    }
}