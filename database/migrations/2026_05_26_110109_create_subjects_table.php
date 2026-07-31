<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {

            $table->id();

            // Secondaire uniquement
            $table->foreignId('level_id')
                ->constrained('levels')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->unique([
                'level_id',
                'slug'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};