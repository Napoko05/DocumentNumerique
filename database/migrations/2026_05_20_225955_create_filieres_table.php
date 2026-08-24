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

            $table->foreignId('academic_domain_id')
                ->constrained('academic_domains')
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('slug');

            $table->text('description')
                ->nullable();

            $table->string('icon')
                ->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index('academic_domain_id');
            $table->index('is_active');

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