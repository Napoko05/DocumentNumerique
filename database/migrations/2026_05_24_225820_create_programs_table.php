<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('formation_id')
                ->constrained('formations')
                ->cascadeOnDelete();

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

            $table->index('formation_id');
            $table->index('is_active');

            $table->unique([
                'formation_id',
                'slug'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};