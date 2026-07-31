<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('academic_domains', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | INFORMATIONS DOMAINE
            |--------------------------------------------------------------------------
            |
            | Exemple :
            |
            | Sciences exactes et technologies
            | Sciences sociales et humaines
            | Langues et communication
            |
            */


            $table->string('name');

            $table->string('slug')
                ->unique();


            $table->text('description')
                ->nullable();


            $table->string('icon')
                ->nullable();



            /*
            |--------------------------------------------------------------------------
            | ORDRE AFFICHAGE
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('position')
                ->default(0);



            /*
            |--------------------------------------------------------------------------
            | STATUT
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

            $table->index('is_active');

            $table->index('position');

        });
    }



    public function down(): void
    {
        Schema::dropIfExists('academic_domains');
    }

};