<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('levels', function (Blueprint $table) {

            $table->string('section')
                ->nullable()
                ->after('filiere_id');

        });
    }


    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {

            $table->dropColumn('section');

        });
    }

};