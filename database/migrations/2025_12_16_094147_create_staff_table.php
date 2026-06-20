<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();

            // =====================
            //  IDENTITÉ
            // =====================
            $table->string('nom');
            $table->string('prenom');
            $table->string('sexe')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();

            // =====================
            //  CONTACT
            // =====================
            $table->string('email')->unique();
            $table->string('tel')->nullable();

            // =====================
            // PROFESSIONNEL
            // =====================
            $table->string('matricule')->unique();
            $table->string('service')->nullable();
            $table->string('ville')->nullable();
            $table->string('specialite')->nullable();

            // =====================
            // IDENTITÉ OFFICIELLE
            // =====================
            $table->string('num_cnib')->nullable();

            // =====================
            // AUTH
            // =====================
            $table->string('password');

            // =====================
            // ROLE SYSTEM (ALIAS)
            // =====================
            $table->string('role_alias')->default('journalist');
            $table->string('role_label')->nullable();

            // =====================
            //  STATUS
            // =====================
            $table->boolean('is_active')->default(true);

            // =====================
            //  DOCUMENTS
            // =====================
            $table->string('cnib_file')->nullable();
            $table->string('attestation_travail_file')->nullable();
            $table->string('diplome_file')->nullable();
            $table->string('signature_file')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};