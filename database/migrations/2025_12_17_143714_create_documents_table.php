<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {

            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('description')->nullable();

            $table->longText('content')->nullable();

            $table->string('category');

            $table->string('level');

            $table->string('cycle')->nullable();

            $table->string('file_path');

            $table->string('cover_image')->nullable();

            $table->enum('access_type', [
                'free',
                'premium'
            ])->default('free');

            $table->decimal('price', 10, 2)
                ->nullable();

            $table->enum('status', [
                'draft',
                'published'
            ])->default('published');

            $table->unsignedBigInteger('views')
                ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
