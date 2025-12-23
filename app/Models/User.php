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
use App\Models\Sale;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Champs autorisés en écriture
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Champs cachés lors de la sérialisation
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts automatiques
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation Many-to-Many avec Book (achats)
     */
    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_user', 'user_id', 'book_id')
            ->withTimestamps();
    }

    /**
     * Vérifie si l'utilisateur a acheté un document
     */
    public function hasPaid(Book $book): bool
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
     * Articles créés par le journaliste (optionnel si différent des documents)
     */
    public function articles()
    {
        return $this->hasMany(Document::class, 'user_id')
            ->where('type', 'article');
    }

    /**
     * Ventes liées au journaliste
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }
}
