<?php

namespace App\Http\Controllers\Paiements;

use App\Models\Document;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function create(Document $document)
    {
        return view(
            'payments.create',
            compact('document')
        );
    }

    public function store(Request $request, Document $document)
    {
        if ($document->access_type !== 'premium') {
            return redirect()
                ->route('documents.show', $document);
        }

        Payment::create([
            'user_id'        => auth()->id(),
            'document_id'    => $document->id,
            'amount'         => $document->price,
            'transaction_id' => 'TEST-' . time(),
            'status'         => 'paid',
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Paiement effectué avec succès.');
    }
}
