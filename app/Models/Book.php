<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'description', 'is_premium'];

    // Relation Many-to-Many avec User (acheteurs)
    public function buyers()
    {
        return $this->belongsToMany(User::class, 'book_user', 'book_id', 'user_id')
                    ->withTimestamps();
    }
}
