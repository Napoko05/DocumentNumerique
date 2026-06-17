<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Staff extends Authenticatable
{
    use HasRoles, Notifiable;

    protected $guard_name = 'web';

    protected $table = 'staff';

    protected $fillable = [

        // identité
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',

        // contact
        'email',
        'tel',

        //  professionnel
        'matricule',
        'service',
        'ville',
        'num_cnib',
        'specialite',

        //  auth
        'password',

        //  ALIAS SYSTEM (IMPORTANT)
        'role_alias',
        'role_label',
        'is_active',

        // documents
        'cnib_file',
        'attestation_travail_file',
        'diplome_file',
        'signature_file',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |------------------------------------------------
    | ROLE CHECK (ALIAS SYSTEM)
    |------------------------------------------------
    */

    public function isAdmin()
    {
        return $this->role_alias === 'admin';
    }

    public function isJournalist()
    {
        return $this->role_alias === 'journalist';
    }

    /*
    |------------------------------------------------
    | FULL NAME
    |------------------------------------------------
    */
    public function getFullNameAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }
    public function roleAlias()
    {
        return $this->roles->first()?->alias_code;
    }
}
