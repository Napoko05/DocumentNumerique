<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_user', function (Blueprint $table) {

            $table->id();
            /*
            |--------------------------------------------------------------------------
            | Document concerné
            |--------------------------------------------------------------------------
            */
            $table->foreignId('document_id')
                ->constrained('documents')
                ->cascadeOnDelete();
            /*
            |--------------------------------------------------------------------------
            | Utilisateur ayant accès
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Type d'accès
            |--------------------------------------------------------------------------
            */

            $table->enum('access_type', [
                'purchase',
                'free',
                'granted'
            ])
            ->default('purchase');

            /*
            |--------------------------------------------------------------------------
            | Informations achat
            |--------------------------------------------------------------------------
            */
            $table->decimal('amount',10,2)
                ->nullable();

            $table->timestamp('accessed_at')
                ->nullable();
            /*
            |--------------------------------------------------------------------------
            | Statut accès
            |--------------------------------------------------------------------------
            */
            $table->enum('status',[
                'active',
                'expired',
                'revoked'
            ])
            ->default('active');
            $table->timestamps();
            /*
            |--------------------------------------------------------------------------
            | Empêcher doublon
            |--------------------------------------------------------------------------
            */
            $table->unique([
                'document_id',
                'user_id'
            ]);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('document_user');
    }
};