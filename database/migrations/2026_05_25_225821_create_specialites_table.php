<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('specialites', function (Blueprint $table) {

            $table->id();

            // Programme ENS
            // Ex : CAPES, CAPCEG...
            $table->foreignId('program_id')
                ->constrained('programs')
                ->cascadeOnDelete();

            // Ex : Mathématiques, Physique-Chimie,
            // Français, Anglais...
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

            $table->index('program_id');

            $table->unique([
                'program_id',
                'slug'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('specialites');
    }
};