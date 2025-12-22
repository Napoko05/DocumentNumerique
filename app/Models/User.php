<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Book;
use App\Models\Document;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];



    // Relation Many-to-Many avec Book (achats)
    public function purchases()
    {
        return $this->belongsToMany(Book::class, 'book_user', 'user_id', 'book_id')
                    ->withTimestamps();
    }

    // Vérifie si l'utilisateur a acheté un document
    public function hasPaid(Book $book)
    {
        return $this->purchases()->where('book_id', $book->id)->exists();
    }
    /**
     * Documents créés par le journaliste
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    /**
     * Articles créés par le journaliste
     * (si c'est différent des documents, sinon tu peux fusionner)
     */
    public function articles()
    {
        return $this->hasMany(Document::class, 'user_id')
                    ->where('type', 'article'); // optionnel
    }

    /**
     * Ventes liées au journaliste
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }

}

