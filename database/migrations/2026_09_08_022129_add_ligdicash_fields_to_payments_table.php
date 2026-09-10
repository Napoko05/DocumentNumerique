<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->text('ligdicash_token')
                ->nullable()
                ->after('payment_reference');

            $table->string('ligdicash_request_id', 100)
                ->nullable()
                ->after('ligdicash_token');

            $table->string('ligdicash_status', 50)
                ->nullable()
                ->after('ligdicash_request_id');

            $table->text('ligdicash_payment_url')
                ->nullable()
                ->after('ligdicash_status');

            $table->json('ligdicash_response')
                ->nullable()
                ->after('ligdicash_payment_url');

            $table->index('ligdicash_request_id');
            $table->index('ligdicash_status');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['ligdicash_request_id']);
            $table->dropIndex(['ligdicash_status']);

            $table->dropColumn([
                'ligdicash_token',
                'ligdicash_request_id',
                'ligdicash_status',
                'ligdicash_payment_url',
                'ligdicash_response',
            ]);
        });
    }
};