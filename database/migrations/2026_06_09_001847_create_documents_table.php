<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {

            $table->id();

            // Auteur
            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();


            // Catégorie pédagogique
            // secondaire / superieur / professionnel
            $table->foreignId('teaching_category_id')
                ->nullable()
                ->constrained('teaching_categories')
                ->nullOnDelete();
            /*
            |--------------------------------------------------------------------------
            | SUPERIEUR
            |--------------------------------------------------------------------------
            | Domaine académique
            |       ↓
            | Formation
            |       ↓
            | Filière
            |       ↓
            | Niveau
            |--------------------------------------------------------------------------
            */

            $table->foreignId('academic_domain_id')
                ->nullable()
                ->constrained('academic_domains')
                ->nullOnDelete();


            $table->foreignId('formation_id')
                ->nullable()
                ->constrained('formations')
                ->nullOnDelete();


            $table->foreignId('filiere_id')
                ->nullable()
                ->constrained('filieres')
                ->nullOnDelete();
            /*
            |--------------------------------------------------------------------------
            | ENS
            |--------------------------------------------------------------------------
            | Formation ENS
            |       ↓
            | Programme
            |       ↓
            | Spécialité
            |       ↓
            | Niveau
            |--------------------------------------------------------------------------
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
            | COMMUN
            |--------------------------------------------------------------------------
            */

            $table->foreignId('level_id')
                ->nullable()
                ->constrained('levels')
                ->nullOnDelete();
            /*
            |--------------------------------------------------------------------------
            | SECONDAIRE UNIQUEMENT
            |--------------------------------------------------------------------------
            */

            $table->foreignId('subject_id')
                ->nullable()
                ->constrained('subjects')
                ->nullOnDelete();
                
            /*
            |--------------------------------------------------------------------------
            | DOCUMENT
            |--------------------------------------------------------------------------
            */

            $table->foreignId('document_type_id')
                ->constrained('document_types')
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('description')
                ->nullable();

            $table->longText('content')
                ->nullable();

            $table->string('slug')
                ->unique();
            // Fichiers

            $table->string('file_path');

            $table->string('cover_image')
                ->nullable();

            $table->unsignedBigInteger('file_size')
                ->nullable();

            $table->string('file_extension', 10)
                ->nullable();
            // Accès

            $table->enum('access_type', [
                'free',
                'premium'
            ])
                ->default('free');


            $table->decimal('price', 10, 2)
                ->nullable();
            // Publication

            $table->enum('status', [
                'draft',
                'pending',
                'published',
                'rejected'
            ])
                ->default('pending');


            $table->timestamp('published_at')
                ->nullable();

            // Statistiques

            $table->unsignedBigInteger('views')
                ->default(0);


            $table->unsignedBigInteger('downloads')
                ->default(0);

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
