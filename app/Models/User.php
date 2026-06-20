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
     * TABLE USERS (lecteurs)
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'statut_compte',
    ];

    /**
     * Champs cachés
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
     * =========================
     * 👤 FULL NAME ACCESSOR
     * =========================
     */
    public function getFullNameAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    /**
     * =========================
     * 📚 ACHATS BOOKS
     * =========================
     */
    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(
            Book::class,
            'book_user',
            'user_id',
            'book_id'
        )->withTimestamps();
    }

    public function hasPaid(Book $book): bool
    {
        return $this->purchases()
            ->where('book_id', $book->id)
            ->exists();
    }

    /**
     * =========================
     * 📄 DOCUMENTS ACHETÉS / CONSULTÉS
     * =========================
     */
    public function documents()
    {
        return $this->belongsToMany(
            Document::class,
            'document_user',
            'user_id',
            'document_id'
        )->withTimestamps();
    }

    /**
     * =========================
     *  SALES (ACHATS)
     * =========================
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
