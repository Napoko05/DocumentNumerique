<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            //  identité
            $table->string('nom');
            $table->string('prenom');

            //  optionnel (remplace "numero")
            $table->string('numero')->nullable();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            //  statut compte global
            $table->enum('statut_compte', ['actif', 'suspendu', 'bloque'])
                ->default('actif');

            // activation rapide
            $table->boolean('is_active')->default(true);

            //  ALIAS ROLE (IMPORTANT - système principal)
            $table->string('role_alias')->default('user');

            //  label affichage (optionnel UI)
            $table->string('role_label')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};