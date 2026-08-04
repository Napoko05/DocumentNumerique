<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Staff extends Authenticatable
{
    use HasRoles;
    use Notifiable;


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'staff';


    /*
    |--------------------------------------------------------------------------
    | GUARD SPATIE
    |--------------------------------------------------------------------------
    */

    protected $guard_name = 'staff';


    /**
     * Retourne le guard utilisé par Spatie Permission.
     */
    public function guardName(): string
    {
        return 'staff';
    }


    /*
    |--------------------------------------------------------------------------
    | CHAMPS AUTORISÉS
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | IDENTITÉ
        |--------------------------------------------------------------------------
        */

        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',


        /*
        |--------------------------------------------------------------------------
        | CONTACT
        |--------------------------------------------------------------------------
        */

        'email',
        'tel',


        /*
        |--------------------------------------------------------------------------
        | INFORMATIONS PROFESSIONNELLES
        |--------------------------------------------------------------------------
        */

        'matricule',
        'service',
        'ville',
        'num_cnib',
        'specialite',


        /*
        |--------------------------------------------------------------------------
        | AUTHENTIFICATION
        |--------------------------------------------------------------------------
        */

        'password',


        /*
        |--------------------------------------------------------------------------
        | RÔLE SYSTÈME
        |--------------------------------------------------------------------------
        */

        'role_alias',
        'role_label',


        /*
        |--------------------------------------------------------------------------
        | ÉTAT
        |--------------------------------------------------------------------------
        */

        'is_active',


        /*
        |--------------------------------------------------------------------------
        | DOCUMENTS DU STAFF
        |--------------------------------------------------------------------------
        */

        'cnib_file',
        'attestation_travail_file',
        'diplome_file',
        'signature_file',

    ];


    /*
    |--------------------------------------------------------------------------
    | CHAMPS CACHÉS
    |--------------------------------------------------------------------------
    */

    protected $hidden = [

        'password',

        'remember_token',

    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'password' => 'hashed',

        'date_naissance' => 'date',

        'is_active' => 'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | NOM COMPLET
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim(
            $this->prenom . ' ' . $this->nom
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION DES RÔLES
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->hasRole(
            'admin'
        );
    }


    public function isJournalist(): bool
    {
        return $this->hasRole(
            'journalist'
        );
    }


    public function isSuperAdmin(): bool
    {
        return $this->hasRole(
            'super_admin'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ALIAS DU RÔLE
    |--------------------------------------------------------------------------
    */

    public function roleAlias(): ?string
    {
        /*
         * Priorité à la colonne role_alias.
         */

        if (!empty($this->role_alias)) {

            return $this->role_alias;

        }

        /*
         * Sinon, récupération du rôle Spatie.
         */

        return $this->getRoleNames()
            ->first();

    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENTS PUBLIÉS
    |--------------------------------------------------------------------------
    */

    public function documents()
    {
        return $this->hasMany(
            Document::class,
            'staff_id'
        );
    }
}
