<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_views', function (Blueprint $table) {

            $table->id();

            // Document consulté
            $table->foreignId('document_id')
                ->constrained('documents')
                ->cascadeOnDelete();

            // Utilisateur connecté (optionnel)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Visiteur non connecté
            $table->ipAddress('ip_address')
                ->nullable();

            // Informations appareil
            $table->string('device')
                ->nullable();

            $table->string('user_agent')
                ->nullable();

            $table->timestamps();


            $table->index('document_id');
            $table->index('user_id');
            $table->index('ip_address');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_views');
    }
};