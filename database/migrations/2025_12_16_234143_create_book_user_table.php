<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_user', function (Blueprint $table) {
            $table->id();
            
            // Clés étrangères
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');

            // Date d'achat ou autres infos
            $table->timestamp('purchased_at')->nullable();

            $table->timestamps();
            
            // Empêche doublons
            $table->unique(['user_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_user');
    }
};
