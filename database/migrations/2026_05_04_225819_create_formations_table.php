<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {

            $table->id();



            /*
            |--------------------------------------------------------------------------
            | CATEGORIE ENSEIGNEMENT
            |--------------------------------------------------------------------------
            |
            | secondaire
            | superieur
            | professionnel
            |
            */

            $table->foreignId('teaching_category_id')
                ->constrained('teaching_categories')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | INFORMATIONS
            |--------------------------------------------------------------------------
            */


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



            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index(
                'teaching_category_id'
            );



            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'teaching_category_id',
                'slug'
            ]);

        });
    }




    public function down(): void
    {
        Schema::dropIfExists('formations');
    }

};