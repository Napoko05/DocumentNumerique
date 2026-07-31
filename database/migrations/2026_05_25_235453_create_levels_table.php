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
            | Utilisé pour :
            |
            | - Secondaire
            | - Professionnel
            | - ENS
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
            | Utilisé pour le supérieur classique
            |
            | Domaine
            |    ↓
            | Filière
            |    ↓
            | Niveau
            |
            */

            $table->foreignId('filiere_id')
                ->nullable()
                ->constrained('filieres')
                ->nullOnDelete();
            /*
            |--------------------------------------------------------------------------
            | PROGRAMME ENS
            |--------------------------------------------------------------------------
            |
            | ENS uniquement
            |
            | ENS
            |  ↓
            | Program
            |  ↓
            | Specialite
            |  ↓
            | Level
            |
            */

            $table->foreignId('program_id')
                ->nullable()
                ->constrained('programs')
                ->nullOnDelete();



            $table->foreignId('specialite_id')
                ->nullable()
                ->constrained('specialites')
                ->nullOnDelete();
            /*
            |--------------------------------------------------------------------------
            | INFORMATIONS NIVEAU
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

            $table->index('program_id');

            $table->index('specialite_id');
            /*
            |--------------------------------------------------------------------------
            | UNIQUE CONTEXTE
            |--------------------------------------------------------------------------
            |
            | Exemple :
            |
            | Informatique
            |      licence-1
            |
            | ENS
            |      CAPES
            |      Maths
            |      premiere-annee
            |
            */

            $table->unique(
                [
                    'formation_id',
                    'filiere_id',
                    'program_id',
                    'specialite_id',
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