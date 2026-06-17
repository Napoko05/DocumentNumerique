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

            //  Auteur
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            //  Infos document
            $table->string('title');
            $table->text('description')->nullable();

            $table->string('category'); // secondary / superior
            $table->string('level');    // 6e, 2nde, licence...
            $table->string('cycle')->nullable(); // 1er-cycle / 2nd-cycle

            //  accès
            $table->string('access_type')->default('free'); // free | premium

            // stats
            $table->unsignedBigInteger('views')->default(0);

            $table->boolean('is_paid')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};