<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Payment;

class CheckDocumentAccess
{
    public function handle(Request $request, Closure $next)
    {
        $document = $request->route('document');

        // 1. Si document gratuit → accès direct
        if ($document->access_type === 'free') {
            return $next($request);
        }

        // 2. Non connecté
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Connexion requise pour accéder à ce document.');
        }

        $user = auth()->user();

        // 3. Admin ou journaliste → accès direct
        if ($user->hasAnyRole(['admin', 'journaliste'])) {
            return $next($request);
        }

        // 4. Vérifier paiement
        $hasPaid = Payment::where('user_id', $user->id)
            ->where('document_id', $document->id)
            ->where('status', 'paid')
            ->exists();

        if ($hasPaid) {
            return $next($request);
        }

        // 5. Sinon → redirection paiement
        return redirect()->route('payment.page', $document->id)
            ->with('error', 'Vous devez payer pour accéder à ce document.');
    }
}