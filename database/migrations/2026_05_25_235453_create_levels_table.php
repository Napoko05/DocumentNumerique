<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | FORMATION
            |--------------------------------------------------------------------------
            |
            | Secondaire
            | Professionnel direct :
            | ENEP / ENSP / ATE
            |
            */

            $table->foreignId('formation_id')
                ->nullable()
                ->constrained('formations')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | FILIERE
            |--------------------------------------------------------------------------
            |
            | Supérieur
            |
            */

            $table->foreignId('filiere_id')
                ->nullable()
                ->constrained('filieres')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | SECTION
            |--------------------------------------------------------------------------
            |
            | Utilisée principalement pour le secondaire.
            |
            | Exemples :
            | - general
            | - technique
            |
            | Peut rester NULL pour :
            | - supérieur
            | - professionnel
            |
            */

            $table->string('section')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | SPECIALITE
            |--------------------------------------------------------------------------
            |
            | Professionnel :
            | - ENS
            | - IDS
            | - UIT
            |
            */

            $table->foreignId('specialite_id')
                ->nullable()
                ->constrained('specialites')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | INFORMATIONS
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('slug');

            $table->unsignedTinyInteger('order')
                ->default(1);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('formation_id');

            $table->index('filiere_id');

            $table->index('specialite_id');

            $table->index('section');

            $table->index('is_active');


            /*
            |--------------------------------------------------------------------------
            | UNICITÉ DU NIVEAU
            |--------------------------------------------------------------------------
            |
            | Un niveau est unique dans son contexte.
            |
            */

            $table->unique(
                [
                    'formation_id',
                    'filiere_id',
                    'specialite_id',
                    'section',
                    'slug'
                ],
                'levels_context_unique'
            );
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};