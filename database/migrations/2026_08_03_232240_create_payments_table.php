<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | UTILISATEUR
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | DOCUMENT PAYÉ
            |--------------------------------------------------------------------------
            */

            $table->foreignId('document_id')
                ->constrained('documents')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | MONTANT
            |--------------------------------------------------------------------------
            */

            $table->decimal('amount', 10, 2);

            $table->string('currency')
                ->default('FCFA');

            /*
            |--------------------------------------------------------------------------
            | MOYEN DE PAIEMENT
            |--------------------------------------------------------------------------
            */

            $table->string('payment_method')
                ->nullable();

           
            /*
            |--------------------------------------------------------------------------
            | TRANSACTION
            |--------------------------------------------------------------------------
            */

            $table->string('transaction_id')
                ->nullable();

            $table->string('payment_reference')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUT
            |--------------------------------------------------------------------------
            */

            $table->string('status')
                ->default('pending');

            /*
            | pending
            | paid
            | failed
            | cancelled
            */

            $table->text('failure_reason')
                ->nullable();

            $table->timestamp('paid_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | DATES
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('transaction_id');
            $table->index('payment_reference');
            $table->index(['user_id', 'document_id']);
            $table->index(['document_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};