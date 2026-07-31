<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {

            $table->id();

            // Document évalué
            $table->foreignId('document_id')
                ->constrained('documents')
                ->cascadeOnDelete();

            // Utilisateur qui note
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Note de 1 à 5
            $table->unsignedTinyInteger('rating');

            // Commentaire optionnel
            $table->text('comment')
                ->nullable();

            $table->timestamps();


            $table->index('document_id');
            $table->index('user_id');


            // Un utilisateur ne note qu'une fois un document
            $table->unique([
                'document_id',
                'user_id'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};