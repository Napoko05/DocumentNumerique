<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teaching_categories', function (Blueprint $table) {

            $table->id();

            // Exemple :
            // secondaire
            // superieur
            // professionnel

            $table->string('name')
                ->unique();

            $table->string('slug')
                ->unique();

            $table->text('description')
                ->nullable();

            $table->string('icon')
                ->nullable();

            $table->unsignedInteger('position')
                ->default(0);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teaching_categories');
    }
};