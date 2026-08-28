<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | NIVEAU
            |--------------------------------------------------------------------------
            |
            | Chaque matière / module appartient à un niveau.
            |
            | Secondaire :
            | Formation → Niveau → Matière
            |
            | Supérieur :
            | Filière → Niveau → Matière
            |
            | Professionnel :
            | Formation → Spécialité → Niveau → Matière
            |
            */

            $table->foreignId('level_id')
                ->constrained('levels')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | INFORMATIONS
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('slug');


            /*
            |--------------------------------------------------------------------------
            | ORDRE D'AFFICHAGE
            |--------------------------------------------------------------------------
            |
            | Exemple :
            |
            | 1 → Mathématiques
            | 2 → Français
            | 3 → Physique
            |
            */

            $table->unsignedInteger('position')
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | ACTIVATION
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('level_id');

            $table->index('is_active');

            $table->index('position');


            /*
            |--------------------------------------------------------------------------
            | UNICITÉ
            |--------------------------------------------------------------------------
            |
            | Une même matière ne peut pas être répétée
            | dans le même niveau avec le même slug.
            |
            */

            $table->unique(
                [
                    'level_id',
                    'slug'
                ],
                'subjects_level_slug_unique'
            );
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};