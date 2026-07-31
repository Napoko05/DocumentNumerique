<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('filieres', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | DOMAINE ACADEMIQUE
            |--------------------------------------------------------------------------
            |
            | Sciences exactes
            |      ↓
            | Informatique
            |
            */

            $table->foreignId('academic_domain_id')
                ->constrained('academic_domains')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | INFORMATIONS FILIERE
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('slug');


            $table->text('description')
                ->nullable();


            $table->string('icon')
                ->nullable();


            $table->boolean('is_active')
                ->default(true);


            $table->timestamps();



            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            |
            | Un domaine ne peut pas avoir deux fois la même filière
            |
            | Exemple :
            |
            | Sciences exactes
            |       Informatique ✅
            |
            | Sciences sociales
            |       Informatique possible si besoin
            |
            */

            $table->unique([
                'academic_domain_id',
                'slug'
            ]);

        });
    }



    public function down(): void
    {
        Schema::dropIfExists('filieres');
    }

};