<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Type d'accès : premium ou free
            if (!Schema::hasColumn('documents', 'access_type')) {
                $table->string('access_type')->default('free');
            }

            // Nombre de vues
            if (!Schema::hasColumn('documents', 'views')) {
                $table->unsignedBigInteger('views')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['access_type', 'views']);
        });
    }
};
