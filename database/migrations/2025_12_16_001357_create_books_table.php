<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            //  contenu
            $table->string('title');
            $table->text('description')->nullable();

            //  accès unique (REMPLACE is_premium + type)
            $table->string('access_type')->default('free'); 
            // free | premium

            //  workflow publication
            $table->string('status')->default('pending');
            // pending | published | rejected

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};