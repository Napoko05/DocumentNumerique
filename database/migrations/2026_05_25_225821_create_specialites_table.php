<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('specialites', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | FORMATION DIRECTE
            |--------------------------------------------------------------------------
            |
            | Utilisée pour :
            |
            | IDS
            | UIT
            |
            */

            $table->foreignId('formation_id')
                ->nullable()
                ->constrained('formations')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | PROGRAMME
            |--------------------------------------------------------------------------
            |
            | Utilisé pour :
            |
            | ENS
            |
            */

            $table->foreignId('program_id')
                ->nullable()
                ->constrained('programs')
                ->cascadeOnDelete();


            $table->string('name');

            $table->string('slug');

            $table->text('description')
                ->nullable();

            $table->string('icon')
                ->nullable();

            $table->unsignedInteger('position')
                ->default(0);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();


            $table->index('formation_id');

            $table->index('program_id');

            $table->index('is_active');


            /*
            |--------------------------------------------------------------------------
            | UNICITÉ
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'formation_id',
                'slug'
            ], 'specialites_formation_slug_unique');

            $table->unique([
                'program_id',
                'slug'
            ], 'specialites_program_slug_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('specialites');
    }
};