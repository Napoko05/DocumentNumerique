<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_types', function (Blueprint $table) {

            $table->id();

            // Ex : Cours, Exercices, Corrigé, Annales,
            // Mémoire, Thèse, Rapport, TP...

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('icon')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};